<template>
  <v-container>
    <v-card>
      <v-card-title>
        Vehicle List
        <v-spacer></v-spacer>
        <v-btn color="primary" @click="openAddDialog">Add Vehicle</v-btn>
      </v-card-title>

      <v-data-table
          :headers="headers"
          :items="vehicles"
          class="elevation-1"
      >
        <template v-slot:item.actions="{ item }">
          <v-btn small color="primary" @click="openEditDialog(item)">Edit</v-btn>
          <v-btn small color="error" @click="deleteVehicle(item.id)">Delete</v-btn>
        </template>
      </v-data-table>
    </v-card>

    <!-- Vehicle edit dialog -->
    <VehicleDialog
        :visible.sync="editDialog"
        :vehicle="editFormData"
        @save="handleSave"
        @cancel="editDialog = false"
    />

    <v-snackbar
        v-model="snackbar"
        :color="snackbarColor"
        timeout="4000"
        top
        right
    >
      {{ snackbarText }}
      <template v-slot:action="{ attrs }">
        <v-btn color="white" text v-bind="attrs" @click="snackbar = false">
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </v-container>
</template>

<script>
import VehicleDialog from "./VehicleDialog.vue";
import { deleteVehicle, getVehicles, saveVehicle } from "../services/vehicleService";

export default {
  name: 'Table',
  components: {
    VehicleDialog
  },
  data() {
    return {
      headers: [
        { text: 'ID', value: 'id' },
        { text: 'Registration', value: 'registrationNumber' },
        { text: 'Brand', value: 'brand' },
        { text: 'Model', value: 'model' },
        { text: 'Type', value: 'type' },
        { text: 'Created At', value: 'createdAt' },
        { text: 'Updated At', value: 'updatedAt' },
        { text: 'Actions', value: 'actions', sortable: false }
      ],
      vehicles: [],
      editDialog: false,
      editFormData: {
        id: null,
        registrationNumber: '',
        brand: '',
        model: '',
        type: ''
      },
      formValid: true,
      snackbar: false,
      snackbarText: '',
      snackbarColor: 'error'
    }
  },
  mounted() {
    this.fetchVehicles()
  },
  methods: {
    async fetchVehicles() {
      try {
        const res = await getVehicles();
        this.vehicles = res.data.results
      } catch (err) {
        console.error('Error fetching data', err)
      }
    },
    openEditDialog(vehicle) {
      this.editFormData = { ...vehicle }
      this.editDialog = true
    },
    openAddDialog() {
      this.editFormData = {
        id: null,
        registrationNumber: '',
        brand: '',
        model: '',
        type: ''
      }
      this.editDialog = true
    },
    async deleteVehicle(id) {
      try {
        await deleteVehicle(id)
        await this.fetchVehicles()
      } catch (err) {
        console.error('Error deleting', err)
      }
    },
    async handleSave(vehicleData) {
      try {
        const data = await saveVehicle(vehicleData.id ?? null, vehicleData)
        console.log(data);
        this.editDialog = false
        await this.fetchVehicles()
      } catch (err) {
        const apiError = err.response?.data?.error || err.message || 'Something went wrong';
        this.snackbarText = 'Save error: ' + apiError
        this.snackbarColor = 'error'
        this.snackbar = true
      }
    },
  }
}
</script>
