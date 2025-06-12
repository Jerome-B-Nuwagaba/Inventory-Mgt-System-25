<template>
  <div class="chat-container">
    <div class="chat-header">
      <h3>Order #{{ orderId }} - Chat</h3>
    </div>
    
    <div class="chat-messages" ref="messageContainer">
      <div v-for="message in messages" :key="message.id" 
           :class="['message', message.sender_id === currentUserId ? 'sent' : 'received']">
        <div class="message-content">
          <div class="message-header">
            <span class="sender-name">{{ message.sender.name }}</span>
            <span class="timestamp">{{ formatTimestamp(message.timestamp) }}</span>
          </div>
          <p class="message-text">{{ message.message }}</p>
        </div>
      </div>
    </div>

    <div class="chat-input">
      <textarea 
        v-model="newMessage" 
        @keyup.enter="sendMessage"
        placeholder="Type your message..."
        rows="3"
      ></textarea>
      <button @click="sendMessage" :disabled="!newMessage.trim()">
        Send
      </button>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, nextTick } from 'vue'
import axios from 'axios'
import { format } from 'date-fns'

export default {
  name: 'ChatInterface',
  props: {
    orderId: {
      type: [String, Number],
      required: true
    },
    receiverId: {
      type: [String, Number],
      required: true
    }
  },
  setup(props) {
    const messages = ref([])
    const newMessage = ref('')
    const messageContainer = ref(null)
    const currentUserId = ref(null)

    const loadMessages = async () => {
      try {
        const response = await axios.get(`/api/chat/order/${props.orderId}`)
        messages.value = response.data.data
        scrollToBottom()
      } catch (error) {
        console.error('Error loading messages:', error)
      }
    }

    const sendMessage = async () => {
      if (!newMessage.value.trim()) return

      try {
        const response = await axios.post('/api/chat/send', {
          receiver_id: props.receiverId,
          order_id: props.orderId,
          message: newMessage.value
        })

        messages.value.push(response.data.data)
        newMessage.value = ''
        await nextTick()
        scrollToBottom()
      } catch (error) {
        console.error('Error sending message:', error)
      }
    }

    const scrollToBottom = () => {
      if (messageContainer.value) {
        messageContainer.value.scrollTop = messageContainer.value.scrollHeight
      }
    }

    const formatTimestamp = (timestamp) => {
      return format(new Date(timestamp), 'MMM d, h:mm a')
    }

    const getCurrentUser = async () => {
      try {
        const response = await axios.get('/api/user')
        currentUserId.value = response.data.id
      } catch (error) {
        console.error('Error getting current user:', error)
      }
    }

    onMounted(() => {
      getCurrentUser()
      loadMessages()
      // Poll for new messages every 30 seconds
      setInterval(loadMessages, 30000)
    })

    return {
      messages,
      newMessage,
      messageContainer,
      currentUserId,
      sendMessage,
      formatTimestamp
    }
  }
}
</script>

<style scoped>
.chat-container {
  display: flex;
  flex-direction: column;
  height: 600px;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  background: white;
}

.chat-header {
  padding: 1rem;
  border-bottom: 1px solid #e2e8f0;
  background: #f8fafc;
}

.chat-messages {
  flex: 1;
  overflow-y: auto;
  padding: 1rem;
}

.message {
  margin-bottom: 1rem;
  max-width: 70%;
}

.message.sent {
  margin-left: auto;
}

.message.received {
  margin-right: auto;
}

.message-content {
  padding: 0.75rem;
  border-radius: 8px;
  background: #f1f5f9;
}

.message.sent .message-content {
  background: #3b82f6;
  color: white;
}

.message-header {
  display: flex;
  justify-content: space-between;
  margin-bottom: 0.25rem;
  font-size: 0.875rem;
}

.sender-name {
  font-weight: 600;
}

.timestamp {
  color: #64748b;
}

.message.sent .timestamp {
  color: #e2e8f0;
}

.chat-input {
  padding: 1rem;
  border-top: 1px solid #e2e8f0;
  display: flex;
  gap: 0.5rem;
}

textarea {
  flex: 1;
  padding: 0.5rem;
  border: 1px solid #e2e8f0;
  border-radius: 4px;
  resize: none;
}

button {
  padding: 0.5rem 1rem;
  background: #3b82f6;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:disabled {
  background: #94a3b8;
  cursor: not-allowed;
}
</style> 