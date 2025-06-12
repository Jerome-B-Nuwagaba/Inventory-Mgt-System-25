<template>
  <div class="manufacturer-dashboard">
    <h1 class="text-2xl font-bold mb-6">Manufacturer Dashboard</h1>
    
    <!-- Production Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Active Production Lines</h3>
        <p class="text-3xl font-bold text-blue-600">{{ activeProductionLines }}</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Cars in Production</h3>
        <p class="text-3xl font-bold text-green-600">{{ carsInProduction }}</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Completed Today</h3>
        <p class="text-3xl font-bold text-purple-600">{{ completedToday }}</p>
      </div>
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Quality Score</h3>
        <p class="text-3xl font-bold text-yellow-600">{{ qualityScore }}%</p>
      </div>
    </div>

    <!-- Production Schedule -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
      <h2 class="text-xl font-bold mb-4">Production Schedule</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead>
            <tr>
              <th class="px-4 py-2">Model</th>
              <th class="px-4 py-2">Line</th>
              <th class="px-4 py-2">Start Date</th>
              <th class="px-4 py-2">End Date</th>
              <th class="px-4 py-2">Status</th>
              <th class="px-4 py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="schedule in productionSchedule" :key="schedule.id">
              <td class="px-4 py-2">{{ schedule.model }}</td>
              <td class="px-4 py-2">{{ schedule.line }}</td>
              <td class="px-4 py-2">{{ schedule.startDate }}</td>
              <td class="px-4 py-2">{{ schedule.endDate }}</td>
              <td class="px-4 py-2">
                <span :class="getStatusClass(schedule.status)">
                  {{ schedule.status }}
                </span>
              </td>
              <td class="px-4 py-2">
                <button class="text-blue-600 hover:text-blue-800 mr-2">Edit</button>
                <button class="text-red-600 hover:text-red-800">Pause</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Finished Vehicle Inventory -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
      <h2 class="text-xl font-bold mb-4">Finished Vehicle Inventory</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full">
          <thead>
            <tr>
              <th class="px-4 py-2">Car ID</th>
              <th class="px-4 py-2">Model</th>
              <th class="px-4 py-2">Production Status</th>
              <th class="px-4 py-2">Warehouse ID</th>
              <th class="px-4 py-2">Quantity</th>
              <th class="px-4 py-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="vehicle in finishedVehicles" :key="vehicle.car_id">
              <td class="px-4 py-2">{{ vehicle.car_id }}</td>
              <td class="px-4 py-2">{{ vehicle.model }}</td>
               <td class="px-4 py-2">
                 <span :class="getProductionStatusClass(vehicle.production_status)">
                   {{ vehicle.production_status }}
                 </span>
              </td>
              <td class="px-4 py-2">{{ vehicle.warehouse_id }}</td>
              <td class="px-4 py-2">{{ vehicle.quantity }}</td>
              <td class="px-4 py-2">
                <button class="text-blue-600 hover:text-blue-800 mr-2">View Details</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Quality Control -->
    <div class="bg-white p-6 rounded-lg shadow">
      <h2 class="text-xl font-bold mb-4">Quality Control</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <h3 class="font-semibold mb-2">Recent Inspections</h3>
          <div class="space-y-2">
            <div v-for="inspection in recentInspections" :key="inspection.id" class="p-2 border rounded">
              <div class="flex justify-between">
                <span>{{ inspection.model }}</span>
                <span :class="getQualityClass(inspection.score)">
                  {{ inspection.score }}%
                </span>
              </div>
              <p class="text-sm text-gray-600">{{ inspection.date }}</p>
            </div>
          </div>
        </div>
        <div>
          <h3 class="font-semibold mb-2">Quality Metrics</h3>
          <div class="space-y-2">
            <div class="flex justify-between">
              <span>Defect Rate</span>
              <span>{{ defectRate }}%</span>
            </div>
            <div class="flex justify-between">
              <span>Customer Satisfaction</span>
              <span>{{ customerSatisfaction }}%</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ManufacturerDashboard',
  data() {
    return {
      activeProductionLines: 0,
      carsInProduction: 0,
      completedToday: 0,
      qualityScore: 0,
      productionSchedule: [],
      finishedVehicles: [],
      recentInspections: [],
      defectRate: 0,
      customerSatisfaction: 0
    }
  },
  methods: {
    async fetchDashboardData() {
      try {
        const response = await axios.get('/api/manufacturer/dashboard-stats')
        const data = response.data
        this.activeProductionLines = data.activeProductionLines
        this.carsInProduction = data.carsInProduction
        this.completedToday = data.completedToday
        this.qualityScore = data.qualityScore
        this.productionSchedule = data.productionSchedule
        this.finishedVehicles = data.finishedVehicles
        this.recentInspections = data.recentInspections
        this.defectRate = data.defectRate
        this.customerSatisfaction = data.customerSatisfaction
      } catch (error) {
        console.error('Error fetching dashboard data:', error)
      }
    },
    getStatusClass(status) {
      const classes = {
        'active': 'text-green-600',
        'paused': 'text-yellow-600',
        'completed': 'text-blue-600',
        'delayed': 'text-red-600'
      }
      return classes[status] || 'text-gray-600'
    },
    getProductionStatusClass(status) {
      const classes = {
        'in_production': 'text-blue-600',
        'completed': 'text-green-600',
        'quality_check': 'text-yellow-600',
        '재고': 'text-purple-600'
      }
      return classes[status] || 'text-gray-600'
    },
    getQualityClass(score) {
      if (score >= 90) return 'text-green-600'
      if (score >= 75) return 'text-yellow-600'
      return 'text-red-600'
    }
  },
  mounted() {
    this.fetchDashboardData()
  }
}
</script>

<style scoped>
.manufacturer-dashboard {
  padding: 2rem;
}
</style> 