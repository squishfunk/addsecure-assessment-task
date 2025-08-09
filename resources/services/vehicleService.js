import axios from 'axios'

export function getVehicles() {
	return axios.get('/vehicles/list')
}

export function saveVehicle(id, data) {
	if(id){
		return axios.post(`/vehicles/save/${id}`, data)
	}else{
		return axios.post(`/vehicles/save`, data)
	}
}

export function deleteVehicle(id) {
	return axios.post(`/vehicles/delete/${id}`)
}