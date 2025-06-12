<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-700">
    <!-- Hero Section -->
    <div class="relative">
      <img src="https://images.unsplash.com/photo-1461632830798-3adb3034e4c8?auto=format&fit=crop&w=1500&q=80" 
           alt="Admin Automotive Hero" 
           class="w-full h-64 object-cover opacity-80 rounded-b-3xl shadow-lg">
      <div class="absolute inset-0 flex flex-col justify-center items-center text-white bg-black bg-opacity-50 rounded-b-3xl">
        <svg class="w-28 h-28 mb-4 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 48 48">
          <rect x="6" y="20" width="36" height="12" rx="6" stroke-width="2.5"/>
          <circle cx="14" cy="36" r="4" stroke-width="2.5"/>
          <circle cx="34" cy="36" r="4" stroke-width="2.5"/>
          <rect x="18" y="14" width="12" height="8" rx="2" stroke-width="2.5"/>
        </svg>
        <h1 class="text-5xl font-extrabold tracking-tight drop-shadow-lg">Admin Dashboard</h1>
        <p class="mt-2 text-xl text-indigo-100 font-medium drop-shadow">Central control for the Automotive Supply Chain</p>
      </div>
    </div>

    <!-- Stat Cards -->
    <div class="max-w-7xl mx-auto px-4 -mt-16 z-10 relative">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
        <div v-for="(stat, index) in stats" :key="index"
             :class="['bg-white bg-opacity-90 rounded-2xl shadow-xl p-6 flex flex-col items-center border-t-4', 
                     `border-${stat.color}-600`]">
          <div :class="['p-3 rounded-full mb-2', `bg-${stat.color}-100`]">
            <component :is="stat.icon" :class="['w-8 h-8', `text-${stat.color}-600`]"/>
          </div>
          <div class="text-gray-600 text-sm font-semibold">{{ stat.label }}</div>
          <div class="text-2xl font-bold text-gray-900">{{ stat.value }}</div>
        </div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="max-w-7xl mx-auto px-4 py-8">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a v-for="(action, index) in quickActions" :key="index"
           :href="action.route"
           :class="['text-white rounded-xl shadow-lg p-6 flex flex-col items-center transition', 
                   `bg-${action.color}-700 hover:bg-${action.color}-800`]">
          <component :is="action.icon" class="w-10 h-10 mb-2"/>
          <span class="font-semibold">{{ action.label }}</span>
        </a>
      </div>
    </div>

    <!-- Recent Registrations & Notifications -->
    <div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- Recent Registrations -->
      <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-indigo-900 mb-6 flex items-center">
          <svg class="w-6 h-6 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
          Recent User Registrations
        </h2>
        <ul>
          <li v-for="user in recentUsers" :key="user.id" 
              class="py-2 border-b border-gray-100 flex justify-between items-center">
            <span class="font-semibold text-gray-800">{{ user.name }}</span>
            <span class="text-xs text-gray-500">{{ formatDate(user.created_at) }}</span>
          </li>
          <li v-if="!recentUsers.length" class="text-gray-500">No recent registrations</li>
        </ul>
      </div>

      <!-- System Notifications -->
      <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-green-900 mb-6 flex items-center">
          <svg class="w-6 h-6 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4"/>
          </svg>
          System Notifications
        </h2>
        <ul>
          <li v-for="notification in notifications" :key="notification.id"
              class="py-2 border-b border-gray-100 flex justify-between items-center">
            <span class="font-semibold text-gray-800">{{ notification.message }}</span>
            <span class="text-xs text-gray-500">{{ formatDate(notification.created_at) }}</span>
          </li>
          <li v-if="!notifications.length" class="text-gray-500">No notifications</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { formatDistanceToNow } from 'date-fns'

export default {
  name: 'AdminDashboard',
  
  setup() {
    const stats = ref([
      {
        label: 'Total Users',
        value: 0,
        color: 'indigo',
        icon: 'UserIcon'
      },
      {
        label: 'Suppliers',
        value: 0,
        color: 'blue',
        icon: 'SupplierIcon'
      },
      {
        label: 'Inventory',
        value: 0,
        color: 'green',
        icon: 'InventoryIcon'
      },
      {
        label: 'Orders',
        value: 0,
        color: 'yellow',
        icon: 'OrderIcon'
      },
      {
        label: 'Reports',
        value: 0,
        color: 'purple',
        icon: 'ReportIcon'
      }
    ])

    const quickActions = ref([
      {
        label: 'Manage Users',
        route: '/users',
        color: 'indigo',
        icon: 'UserIcon'
      },
      {
        label: 'Inventory',
        route: '/inventory',
        color: 'blue',
        icon: 'InventoryIcon'
      },
      {
        label: 'Orders',
        route: '/orders',
        color: 'green',
        icon: 'OrderIcon'
      },
      {
        label: 'Reports',
        route: '/reports',
        color: 'purple',
        icon: 'ReportIcon'
      }
    ])

    const recentUsers = ref([])
    const notifications = ref([])

    const fetchDashboardData = async () => {
      try {
        const response = await axios.get('/api/admin/dashboard')
        const data = response.data

        // Update stats
        stats.value[0].value = data.totalUsers
        stats.value[1].value = data.totalSuppliers
        stats.value[2].value = data.totalInventory
        stats.value[3].value = data.totalOrders
        stats.value[4].value = data.totalReports

        // Update recent users and notifications
        recentUsers.value = data.recentUsers
        notifications.value = data.notifications
      } catch (error) {
        console.error('Error fetching dashboard data:', error)
      }
    }

    const formatDate = (date) => {
      return formatDistanceToNow(new Date(date), { addSuffix: true })
    }

    onMounted(() => {
      fetchDashboardData()
    })

    return {
      stats,
      quickActions,
      recentUsers,
      notifications,
      formatDate
    }
  }
}
</script>

<style scoped>
/* Add any component-specific styles here */
</style> 