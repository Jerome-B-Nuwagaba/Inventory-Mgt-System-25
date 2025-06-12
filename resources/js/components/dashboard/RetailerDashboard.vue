<template>
  <div class="retailer-dashboard">
    <h1 class="text-2xl font-bold mb-6">Retailer Dashboard</h1>
    
    <!-- Sales Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Today's Sales</h3>
        <p class="text-3xl font-bold text-blue-600">${{ todaySales }}</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Vehicles in Stock</h3>
        <p class="text-3xl font-bold text-green-600">{{ vehiclesInStock }}</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Pending Orders</h3>
        <p class="text-3xl font-bold text-purple-600">{{ pendingOrders }}</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Customer Satisfaction</h3>
        <p class="text-3xl font-bold text-yellow-600">{{ customerSatisfaction }}%</p>
      </div>
    </div>

    <!-- Sales Management -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
      <h2 class="text-xl font-bold mb-4">Sales Management</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead>
            <tr>
              <th class="px-4 py-2">Order ID</th>
              <th class="px-4 py-2">Customer</th>
              <th class="px-4 py-2">Vehicle</th>
              <th class="px-4 py-2">Amount</th>
              <th class="px-4 py-2">Status</th>
              <th class="px-4 py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="sale in sales" :key="sale.id">
              <td class="px-4 py-2">{{ sale.id }}</td>
              <td class="px-4 py-2">{{ sale.customer }}</td>
              <td class="px-4 py-2">{{ sale.vehicle }}</td>
              <td class="px-4 py-2">${{ sale.amount }}</td>
              <td class="px-4 py-2">
                <span :class="getStatusClass(sale.status)">
                  {{ sale.status }}
                </span>
              </td>
              <td class="px-4 py-2">
                <button class="text-blue-600 hover:text-blue-800 mr-2">View</button>
                <button class="text-green-600 hover:text-green-800">Process</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Inventory Management -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
      <h2 class="text-xl font-bold mb-4">Inventory Management</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <h3 class="font-semibold mb-2">Vehicle Inventory</h3>
          <div class="space-y-2">
            <div v-for="vehicle in inventory" :key="vehicle.id" class="flex justify-between items-center p-2 border rounded">
              <div>
                <span class="font-medium">{{ vehicle.model }}</span>
                <p class="text-sm text-gray-600">{{ vehicle.variant }}</p>
              </div>
              <div class="text-right">
                <span :class="getStockLevelClass(vehicle.stockLevel)">
                  {{ vehicle.quantity }} units
                </span>
                <p class="text-sm text-gray-600">Price: ${{ vehicle.price }}</p>
              </div>
            </div>
          </div>
        </div>
        <div>
          <h3 class="font-semibold mb-2">Sales Metrics</h3>
          <div class="space-y-4">
            <div>
              <h4 class="text-sm font-medium text-gray-600">Monthly Performance</h4>
              <div class="flex justify-between items-center">
                <span>Sales Target</span>
                <span>${{ monthlyTarget }}</span>
              </div>
              <div class="flex justify-between items-center">
                <span>Current Sales</span>
                <span>${{ currentSales }}</span>
              </div>
            </div>
            <div>
              <h4 class="text-sm font-medium text-gray-600">Top Selling Models</h4>
              <div v-for="model in topSellingModels" :key="model.name" class="flex justify-between items-center">
                <span>{{ model.name }}</span>
                <span>{{ model.sales }} units</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Customer Management -->
    <div class="bg-white p-6 rounded-lg shadow">
      <h2 class="text-xl font-bold mb-4">Customer Management</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-4 border rounded">
          <h3 class="font-semibold mb-2">Customer Satisfaction</h3>
          <div class="space-y-2">
            <div class="flex justify-between">
              <span>Overall Rating</span>
              <span>{{ customerSatisfaction }}%</span>
            </div>
            <div class="flex justify-between">
              <span>Reviews</span>
              <span>{{ totalReviews }}</span>
            </div>
          </div>
        </div>
        <div class="p-4 border rounded">
          <h3 class="font-semibold mb-2">Service Requests</h3>
          <div class="space-y-2">
            <div class="flex justify-between">
              <span>Pending</span>
              <span>{{ pendingServiceRequests }}</span>
            </div>
            <div class="flex justify-between">
              <span>Completed</span>
              <span>{{ completedServiceRequests }}</span>
            </div>
          </div>
        </div>
        <div class="p-4 border rounded">
          <h3 class="font-semibold mb-2">Customer Retention</h3>
          <div class="space-y-2">
            <div class="flex justify-between">
              <span>Repeat Customers</span>
              <span>{{ repeatCustomers }}%</span>
            </div>
            <div class="flex justify-between">
              <span>Loyalty Score</span>
              <span>{{ loyaltyScore }}%</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'RetailerDashboard',
  data() {
    return {
      todaySales: 0,
      vehiclesInStock: 0,
      pendingOrders: 0,
      customerSatisfaction: 0,
      sales: [],
      inventory: [],
      monthlyTarget: 0,
      currentSales: 0,
      topSellingModels: [],
      totalReviews: 0,
      pendingServiceRequests: 0,
      completedServiceRequests: 0,
      repeatCustomers: 0,
      loyaltyScore: 0
    }
  },
  methods: {
    async fetchDashboardData() {
      try {
        const response = await axios.get('/api/retailer/dashboard-stats')
        const data = response.data
        this.todaySales = data.todaySales
        this.vehiclesInStock = data.vehiclesInStock
        this.pendingOrders = data.pendingOrders
        this.customerSatisfaction = data.customerSatisfaction
        this.sales = data.sales
        this.inventory = data.inventory
        this.monthlyTarget = data.monthlyTarget
        this.currentSales = data.currentSales
        this.topSellingModels = data.topSellingModels
        this.totalReviews = data.totalReviews
        this.pendingServiceRequests = data.pendingServiceRequests
        this.completedServiceRequests = data.completedServiceRequests
        this.repeatCustomers = data.repeatCustomers
        this.loyaltyScore = data.loyaltyScore
      } catch (error) {
        console.error('Error fetching dashboard data:', error)
      }
    },
    getStatusClass(status) {
      const classes = {
        'pending': 'text-yellow-600',
        'processing': 'text-blue-600',
        'completed': 'text-green-600',
        'cancelled': 'text-red-600'
      }
      return classes[status] || 'text-gray-600'
    },
    getStockLevelClass(level) {
      const classes = {
        'low': 'text-red-600',
        'medium': 'text-yellow-600',
        'high': 'text-green-600'
      }
      return classes[level] || 'text-gray-600'
    }
  },
  mounted() {
    this.fetchDashboardData()
  }
}
</script>

<style scoped>
.retailer-dashboard {
  padding: 2rem;
}
</style> 