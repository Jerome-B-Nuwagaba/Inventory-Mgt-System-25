<template>
  <div class="supplier-dashboard">
    <h1 class="text-2xl font-bold mb-6">Supplier Dashboard</h1>
    
    <!-- Supply Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Active Orders</h3>
        <p class="text-3xl font-bold text-blue-600">{{ activeOrders }}</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Parts in Stock</h3>
        <p class="text-3xl font-bold text-green-600">{{ partsInStock }}</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Pending Deliveries</h3>
        <p class="text-3xl font-bold text-purple-600">{{ pendingDeliveries }}</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">On-Time Delivery</h3>
        <p class="text-3xl font-bold text-yellow-600">{{ onTimeDelivery }}%</p>
      </div>
    </div>

    <!-- Order Management -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
      <h2 class="text-xl font-bold mb-4">Order Management</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead>
            <tr>
              <th class="px-4 py-2">Order ID</th>
              <th class="px-4 py-2">Part</th>
              <th class="px-4 py-2">Quantity</th>
              <th class="px-4 py-2">Due Date</th>
              <th class="px-4 py-2">Status</th>
              <th class="px-4 py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in orders" :key="order.id">
              <td class="px-4 py-2">{{ order.id }}</td>
              <td class="px-4 py-2">{{ order.part }}</td>
              <td class="px-4 py-2">{{ order.quantity }}</td>
              <td class="px-4 py-2">{{ order.dueDate }}</td>
              <td class="px-4 py-2">
                <span :class="getStatusClass(order.status)">
                  {{ order.status }}
                </span>
              </td>
              <td class="px-4 py-2">
                <button class="text-blue-600 hover:text-blue-800 mr-2">Update</button>
                <button class="text-green-600 hover:text-green-800">Ship</button>
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
          <h3 class="font-semibold mb-2">Parts Inventory</h3>
          <div class="space-y-2">
            <div v-for="part in inventory" :key="part.id" class="flex justify-between items-center p-2 border rounded">
              <div>
                <span class="font-medium">{{ part.name }}</span>
                <p class="text-sm text-gray-600">{{ part.sku }}</p>
              </div>
              <div class="text-right">
                <span :class="getStockLevelClass(part.stockLevel)">
                  {{ part.quantity }} units
                </span>
                <p class="text-sm text-gray-600">Reorder: {{ part.reorderPoint }}</p>
              </div>
            </div>
          </div>
        </div>
        <div>
          <h3 class="font-semibold mb-2">Supply Chain Metrics</h3>
          <div class="space-y-4">
            <div>
              <h4 class="text-sm font-medium text-gray-600">Lead Time</h4>
              <div class="flex justify-between items-center">
                <span>Average</span>
                <span>{{ averageLeadTime }} days</span>
              </div>
            </div>
            <div>
              <h4 class="text-sm font-medium text-gray-600">Quality Metrics</h4>
              <div class="flex justify-between items-center">
                <span>Defect Rate</span>
                <span>{{ defectRate }}%</span>
              </div>
            </div>
            <div>
              <h4 class="text-sm font-medium text-gray-600">Cost Metrics</h4>
              <div class="flex justify-between items-center">
                <span>Average Cost</span>
                <span>${{ averageCost }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Supplier Performance -->
    <div class="bg-white p-6 rounded-lg shadow">
      <h2 class="text-xl font-bold mb-4">Performance Metrics</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-4 border rounded">
          <h3 class="font-semibold mb-2">Delivery Performance</h3>
          <div class="space-y-2">
            <div class="flex justify-between">
              <span>On-Time Delivery</span>
              <span>{{ onTimeDelivery }}%</span>
            </div>
            <div class="flex justify-between">
              <span>Late Deliveries</span>
              <span>{{ lateDeliveries }}</span>
            </div>
          </div>
        </div>
        <div class="p-4 border rounded">
          <h3 class="font-semibold mb-2">Quality Performance</h3>
          <div class="space-y-2">
            <div class="flex justify-between">
              <span>Quality Score</span>
              <span>{{ qualityScore }}%</span>
            </div>
            <div class="flex justify-between">
              <span>Returns Rate</span>
              <span>{{ returnsRate }}%</span>
            </div>
          </div>
        </div>
        <div class="p-4 border rounded">
          <h3 class="font-semibold mb-2">Cost Performance</h3>
          <div class="space-y-2">
            <div class="flex justify-between">
              <span>Cost Variance</span>
              <span>{{ costVariance }}%</span>
            </div>
            <div class="flex justify-between">
              <span>Price Competitiveness</span>
              <span>{{ priceCompetitiveness }}%</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SupplierDashboard',
  data() {
    return {
      activeOrders: 0,
      partsInStock: 0,
      pendingDeliveries: 0,
      onTimeDelivery: 0,
      orders: [],
      inventory: [],
      averageLeadTime: 0,
      defectRate: 0,
      averageCost: 0,
      lateDeliveries: 0,
      qualityScore: 0,
      returnsRate: 0,
      costVariance: 0,
      priceCompetitiveness: 0
    }
  },
  methods: {
    async fetchDashboardData() {
      try {
        const response = await axios.get('/api/supplier/dashboard-stats')
        const data = response.data
        this.activeOrders = data.activeOrders
        this.partsInStock = data.partsInStock
        this.pendingDeliveries = data.pendingDeliveries
        this.onTimeDelivery = data.onTimeDelivery
        this.orders = data.orders
        this.inventory = data.inventory
        this.averageLeadTime = data.averageLeadTime
        this.defectRate = data.defectRate
        this.averageCost = data.averageCost
        this.lateDeliveries = data.lateDeliveries
        this.qualityScore = data.qualityScore
        this.returnsRate = data.returnsRate
        this.costVariance = data.costVariance
        this.priceCompetitiveness = data.priceCompetitiveness
      } catch (error) {
        console.error('Error fetching dashboard data:', error)
      }
    },
    getStatusClass(status) {
      const classes = {
        'pending': 'text-yellow-600',
        'processing': 'text-blue-600',
        'shipped': 'text-green-600',
        'delayed': 'text-red-600'
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
.supplier-dashboard {
  padding: 2rem;
}
</style> 