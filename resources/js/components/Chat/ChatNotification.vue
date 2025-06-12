<template>
  <div class="chat-notification">
    <div class="notification-icon" @click="toggleDropdown">
      <i class="fas fa-comments"></i>
      <span v-if="unreadCount > 0" class="badge">{{ unreadCount }}</span>
    </div>

    <div v-if="showDropdown" class="notification-dropdown">
      <div v-if="unreadMessages.length === 0" class="no-messages">
        No new messages
      </div>
      <div v-else class="message-list">
        <div v-for="message in unreadMessages" 
             :key="message.id" 
             class="message-item"
             @click="openChat(message)">
          <div class="message-preview">
            <span class="sender">{{ message.sender.name }}</span>
            <span class="order">Order #{{ message.order_id }}</span>
          </div>
          <p class="message-text">{{ truncateMessage(message.message) }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue'
import axios from 'axios'

export default {
  name: 'ChatNotification',
  setup() {
    const unreadMessages = ref([])
    const showDropdown = ref(false)
    const unreadCount = ref(0)
    let pollInterval

    const loadUnreadMessages = async () => {
      try {
        const response = await axios.get('/api/chat/unread')
        unreadMessages.value = response.data.data
        unreadCount.value = unreadMessages.value.length
      } catch (error) {
        console.error('Error loading unread messages:', error)
      }
    }

    const toggleDropdown = () => {
      showDropdown.value = !showDropdown.value
    }

    const openChat = (message) => {
      // Emit event to parent to open chat for this order
      emit('open-chat', message.order_id)
      showDropdown.value = false
    }

    const truncateMessage = (message) => {
      return message.length > 50 ? message.substring(0, 50) + '...' : message
    }

    const handleClickOutside = (event) => {
      if (!event.target.closest('.chat-notification')) {
        showDropdown.value = false
      }
    }

    onMounted(() => {
      loadUnreadMessages()
      // Poll for new messages every 30 seconds
      pollInterval = setInterval(loadUnreadMessages, 30000)
      document.addEventListener('click', handleClickOutside)
    })

    onUnmounted(() => {
      clearInterval(pollInterval)
      document.removeEventListener('click', handleClickOutside)
    })

    return {
      unreadMessages,
      showDropdown,
      unreadCount,
      toggleDropdown,
      openChat,
      truncateMessage
    }
  }
}
</script>

<style scoped>
.chat-notification {
  position: relative;
}

.notification-icon {
  position: relative;
  cursor: pointer;
  padding: 0.5rem;
}

.badge {
  position: absolute;
  top: -5px;
  right: -5px;
  background: #ef4444;
  color: white;
  border-radius: 50%;
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem;
}

.notification-dropdown {
  position: absolute;
  top: 100%;
  right: 0;
  width: 300px;
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
  z-index: 50;
}

.no-messages {
  padding: 1rem;
  text-align: center;
  color: #64748b;
}

.message-list {
  max-height: 400px;
  overflow-y: auto;
}

.message-item {
  padding: 1rem;
  border-bottom: 1px solid #e2e8f0;
  cursor: pointer;
}

.message-item:hover {
  background: #f8fafc;
}

.message-preview {
  display: flex;
  justify-content: space-between;
  margin-bottom: 0.5rem;
}

.sender {
  font-weight: 600;
  color: #1e293b;
}

.order {
  color: #64748b;
  font-size: 0.875rem;
}

.message-text {
  color: #475569;
  font-size: 0.875rem;
  margin: 0;
}
</style> 