<template>
  <div class="admin-dashboard">
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>
    
    <!-- System Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Total Users</h3>
        <p class="text-3xl font-bold text-blue-600">{{ totalUsers }}</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Active Orders</h3>
        <p class="text-3xl font-bold text-green-600">{{ activeOrders }}</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Pending Vendors</h3>
        <p class="text-3xl font-bold text-yellow-600">{{ pendingVendors }}</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Low Stock Alerts</h3>
        <p class="text-3xl font-bold text-red-600">{{ lowStockAlerts }}</p>
      </div>
    </div>

    <!-- User Management Section -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
      <h2 class="text-xl font-bold mb-4">User Management</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead>
            <tr>
              <th class="px-4 py-2">Name</th>
              <th class="px-4 py-2">Role</th>
              <th class="px-4 py-2">Status</th>
              <th class="px-4 py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td class="px-4 py-2">{{ user.name }}</td>
              <td class="px-4 py-2">{{ user.role }}</td>
              <td class="px-4 py-2">
                <span :class="user.status === 'active' ? 'text-green-600' : 'text-red-600'">
                  {{ user.status }}
                </span>
              </td>
              <td class="px-4 py-2">
                <button class="text-blue-600 hover:text-blue-800 mr-2">Edit</button>
                <button class="text-red-600 hover:text-red-800">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Vendor Management Section -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
      <h2 class="text-xl font-bold mb-4">Vendor Management</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead>
            <tr>
              <th class="px-4 py-2">Vendor Name</th>
              <th class="px-4 py-2">Status</th>
              <th class="px-4 py-2">Score</th>
              <th class="px-4 py-2">Application PDF</th>
              <th class="px-4 py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="vendor in vendors" :key="vendor.id">
              <td class="px-4 py-2">{{ vendor.name }}</td>
              <td class="px-4 py-2">
                 <span :class="getVendorStatusClass(vendor.status)">
                  {{ vendor.status }}
                </span>
              </td>
              <td class="px-4 py-2">{{ vendor.score }}</td>
               <td class="px-4 py-2">
                <a :href="vendor.application_pdf_path" target="_blank" class="text-blue-600 hover:underline" v-if="vendor.application_pdf_path">View PDF</a>
                <span v-else>N/A</span>
              </td>
              <td class="px-4 py-2">
                <button class="text-green-600 hover:text-green-800 mr-2" v-if="vendor.status === 'pending'">Approve</button>
                <button class="text-red-600 hover:text-red-800" v-if="vendor.status === 'pending'">Reject</button>
                <span v-else>N/A</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Recent Activity and Reports -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
      <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Recent Activity</h2>
        <ul class="space-y-2">
          <li v-for="activity in recentActivity" :key="activity.id" class="p-2 border rounded text-sm text-gray-700">
            {{ activity.description }} - <span class="text-gray-500 text-xs">{{ activity.timestamp }}</span>
          </li>
        </ul>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Reports</h2>
        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4">
          Generate System Report
        </button>
        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
          Generate Vendor Report
        </button>
      </div>
    </div>

    <!-- System Settings -->
    <div class="bg-white p-6 rounded-lg shadow">
      <h2 class="text-xl font-bold mb-4">System Settings</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <h3 class="font-semibold mb-2">Notification Settings</h3>
          <div class="space-y-2">
            <label class="flex items-center">
              <input type="checkbox" v-model="settings.emailNotifications" class="mr-2">
              Email Notifications
            </label>
            <label class="flex items-center">
              <input type="checkbox" v-model="settings.systemAlerts" class="mr-2">
              System Alerts
            </label>
          </div>
        </div>
        <div>
          <h3 class="font-semibold mb-2">System Maintenance</h3>
          <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Run System Check
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AdminDashboard',
  data() {
    return {
      totalUsers: 0,
      activeOrders: 0,
      pendingVendors: 0,
      lowStockAlerts: 0,
      systemHealth: 98, // Placeholder for system health metric
      users: [],
      vendors: [], // Data based on the Data Dictionary
      recentActivity: [], // Placeholder for recent activity feed
      settings: {
        emailNotifications: true,
        systemAlerts: true
      }
    }
  },
  methods: {
    async fetchDashboardData() {
      try {
        // Fetch users, orders, vendors, alerts, and activity
        const response = await axios.get('/api/admin/dashboard-stats')
        const data = response.data;
        this.totalUsers = data.totalUsers;
        this.activeOrders = data.activeOrders;
        this.pendingVendors = data.pendingVendors;
        this.lowStockAlerts = data.lowStockAlerts;
        this.users = data.users;
        this.vendors = data.vendors; // Assign fetched vendor data
        this.recentActivity = data.recentActivity; // Assign fetched activity data

      } catch (error) {
        console.error('Error fetching dashboard data:', error)
      }
    },
    getVendorStatusClass(status) {
      const classes = {
        'pending': 'text-yellow-600',
        'validated': 'text-green-600',
        'rejected': 'text-red-600'
      }
      return classes[status] || 'text-gray-600'
    }
  },
  mounted() {
    this.fetchDashboardData()
  }
}
</script>

<style scoped>
.admin-dashboard {
  padding: 2rem;
}
</style> 