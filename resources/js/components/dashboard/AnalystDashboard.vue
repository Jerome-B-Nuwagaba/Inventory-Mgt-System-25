<template>
  <div class="analyst-dashboard">
    <h1 class="text-2xl font-bold mb-6">Analyst Dashboard</h1>
    
    <!-- Key Metrics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Supply Chain Efficiency</h3>
        <p class="text-3xl font-bold text-blue-600">{{ supplyChainEfficiency }}%</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Inventory Turnover</h3>
        <p class="text-3xl font-bold text-green-600">{{ inventoryTurnover }}x</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Order Fulfillment</h3>
        <p class="text-3xl font-bold text-purple-600">{{ orderFulfillment }}%</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Cost Efficiency</h3>
        <p class="text-3xl font-bold text-yellow-600">{{ costEfficiency }}%</p>
      </div>
    </div>

    <!-- Supply Chain Analytics -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
      <h2 class="text-xl font-bold mb-4">Supply Chain Analytics</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <h3 class="font-semibold mb-2">Lead Time Analysis</h3>
          <div class="space-y-4">
            <div v-for="metric in leadTimeMetrics" :key="metric.name" class="flex justify-between items-center p-2 border rounded">
              <span>{{ metric.name }}</span>
              <span>{{ metric.value }} days</span>
            </div>
          </div>
        </div>
        <div>
          <h3 class="font-semibold mb-2">Cost Analysis</h3>
          <div class="space-y-4">
            <div v-for="cost in costMetrics" :key="cost.name" class="flex justify-between items-center p-2 border rounded">
              <span>{{ cost.name }}</span>
              <span>${{ cost.value }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Performance Metrics -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
      <h2 class="text-xl font-bold mb-4">Performance Metrics</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-4 border rounded">
          <h3 class="font-semibold mb-2">Supplier Performance</h3>
          <div class="space-y-2">
            <div v-for="supplier in supplierPerformance" :key="supplier.name" class="flex justify-between items-center">
              <span>{{ supplier.name }}</span>
              <span :class="getPerformanceClass(supplier.score)">
                {{ supplier.score }}%
              </span>
            </div>
          </div>
        </div>
        <div class="p-4 border rounded">
          <h3 class="font-semibold mb-2">Manufacturing Efficiency</h3>
          <div class="space-y-2">
            <div v-for="metric in manufacturingMetrics" :key="metric.name" class="flex justify-between items-center">
              <span>{{ metric.name }}</span>
              <span>{{ metric.value }}%</span>
            </div>
          </div>
        </div>
        <div class="p-4 border rounded">
          <h3 class="font-semibold mb-2">Quality Metrics</h3>
          <div class="space-y-2">
            <div v-for="metric in qualityMetrics" :key="metric.name" class="flex justify-between items-center">
              <span>{{ metric.name }}</span>
              <span>{{ metric.value }}%</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Trend Analysis -->
    <div class="bg-white p-6 rounded-lg shadow">
      <h2 class="text-xl font-bold mb-4">Trend Analysis</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <h3 class="font-semibold mb-2">Demand Forecasting</h3>
          <div class="space-y-4">
            <div v-for="forecast in demandForecasts" :key="forecast.model" class="p-2 border rounded">
              <div class="flex justify-between items-center">
                <span class="font-medium">{{ forecast.model }}</span>
                <span>{{ forecast.trend }}</span>
              </div>
              <p class="text-sm text-gray-600">Next Quarter: {{ forecast.nextQuarter }}</p>
            </div>
          </div>
        </div>
        <div>
          <h3 class="font-semibold mb-2">Market Analysis</h3>
          <div class="space-y-4">
            <div v-for="analysis in marketAnalysis" :key="analysis.category" class="p-2 border rounded">
              <div class="flex justify-between items-center">
                <span class="font-medium">{{ analysis.category }}</span>
                <span :class="getTrendClass(analysis.trend)">
                  {{ analysis.trend }}
                </span>
              </div>
              <p class="text-sm text-gray-600">{{ analysis.description }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AnalystDashboard',
  data() {
    return {
      supplyChainEfficiency: 0,
      inventoryTurnover: 0,
      orderFulfillment: 0,
      costEfficiency: 0,
      leadTimeMetrics: [],
      costMetrics: [],
      supplierPerformance: [],
      manufacturingMetrics: [],
      qualityMetrics: [],
      demandForecasts: [],
      marketAnalysis: []
    }
  },
  methods: {
    async fetchDashboardData() {
      try {
        const response = await axios.get('/api/analyst/dashboard-stats')
        const data = response.data
        this.supplyChainEfficiency = data.supplyChainEfficiency
        this.inventoryTurnover = data.inventoryTurnover
        this.orderFulfillment = data.orderFulfillment
        this.costEfficiency = data.costEfficiency
        this.leadTimeMetrics = data.leadTimeMetrics
        this.costMetrics = data.costMetrics
        this.supplierPerformance = data.supplierPerformance
        this.manufacturingMetrics = data.manufacturingMetrics
        this.qualityMetrics = data.qualityMetrics
        this.demandForecasts = data.demandForecasts
        this.marketAnalysis = data.marketAnalysis
      } catch (error) {
        console.error('Error fetching dashboard data:', error)
      }
    },
    getPerformanceClass(score) {
      if (score >= 90) return 'text-green-600'
      if (score >= 75) return 'text-yellow-600'
      return 'text-red-600'
    },
    getTrendClass(trend) {
      const classes = {
        'increasing': 'text-green-600',
        'stable': 'text-blue-600',
        'decreasing': 'text-red-600'
      }
      return classes[trend] || 'text-gray-600'
    }
  },
  mounted() {
    this.fetchDashboardData()
  }
}
</script>

<style scoped>
.analyst-dashboard {
  padding: 2rem;
}
</style> 