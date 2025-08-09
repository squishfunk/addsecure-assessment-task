<template>
  <v-dialog v-model="localVisible" max-width="500px">
    <v-card>
      <v-card-title>{{ localVehicle.id ? 'Edit Vehicle' : 'Add Vehicle' }}</v-card-title>
      <v-card-text>
        <v-form ref="form" v-model="formValid">
          <v-text-field
              label="Registration Number"
              v-model="localVehicle.registrationNumber"
              :rules="[v => !!v || 'Required']"
          ></v-text-field>
          <v-text-field
              label="Brand"
              v-model="localVehicle.brand"
              :rules="[v => !!v || 'Required']"
          ></v-text-field>
          <v-text-field
              label="Model"
              v-model="localVehicle.model"
              :rules="[v => !!v || 'Required']"
          ></v-text-field>
          <v-select
              v-model="localVehicle.type"
              :items="['passenger', 'bus', 'truck']"
              label="Vehicle Type"
          ></v-select>
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn text @click="cancel">Cancel</v-btn>
        <v-btn color="primary" @click="save">{{ localVehicle.id ? 'Save' : 'Add' }}</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: 'VehicleDialog',
  props: {
    visible: Boolean,
    vehicle: Object
  },
  data() {
    return {
      localVisible: this.visible,
      localVehicle: { ...this.vehicle },
      formValid: true
    }
  },
  watch: {
    visible(newVal) {
      this.localVisible = newVal;
      if (newVal) {
        this.localVehicle = { ...this.vehicle };
      }
    },
    localVisible(newVal) {
      this.$emit('update:visible', newVal);
    }
  },
  methods: {
    save() {
      if (!this.$refs.form.validate()) return;
      this.$emit('save', this.localVehicle);
      this.localVisible = false;
    },
    cancel() {
      this.localVisible = false;
      this.$emit('cancel');
    }
  }
}
</script>
