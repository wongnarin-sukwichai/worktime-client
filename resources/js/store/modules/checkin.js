import axios from "axios";

/** หน้าที่หลักๆของ Vuex คือการดึงข้อมูลจาก database จากนั้นเราก็นำข้อมูลที่ได้นั้นมาเตรียมข้อมูลไว้่ เพื่อให้เราสะดวกในการนำไปแสดงที่หน้าเว็บไซต์ผ่าน computed อีกที */

export default {
    //สร้างตัวแปรนั่นแหละ
    state() {
        return {
            checkin: null,
        };
    },
    getters: {
        //getter เหมือนการสร้าง function ไว้รอเราเรียกใช้

        getProfileName(state) {
            return state.checkin.name + ' ' + state.checkin.surname
        },
        getTimeIn(state) {
            return state.checkin.timein
        },
        getTimeOut(state) {
            return state.checkin.timeout
        }
    },
    mutations: {
        //mutaion รับค่าจาก action ผ่านคำสั่ง commit แล้วนำมาเปลี่ยนแปลงข้อมูลใน state (ด้านบน)
        getProfile(state, payload) {
            state.checkin = payload
        }
    },
    actions: {
        //action ส่วนในการคำนวณ ติดต่อข้อมูล api จาก backend ในที่นี้คือ axios ของ laravel นั่นเอง

        async storeCheckin({ dispatch }, payload) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/api/store', payload)
                .then((response) => {
                    return dispatch('setProfile', response.data)
                    //console.log(response.data)
                }).catch ((err) => {
                    throw err.response
                    // console.log(err)
                })
            } catch (e) {
                throw e
            }
        },

        async storeCheckout({ dispatch }, payload) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/api/checkout', payload)
                .then((response) => {
                    return dispatch('setProfile', response.data)
                    //console.log(response.data)
                }).catch ((err) => {
                    throw err.response
                    // console.log(err)
                })
            } catch (e) {
                throw e
            }
        },

        async storeOtin({ dispatch }, payload) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/api/otin', payload)
                .then((response) => {
                    return dispatch('setProfile', response.data)
                    //console.log(response.data)
                }).catch ((err) => {
                    throw err.response
                    // console.log(err)
                })
            } catch (e) {
                throw e
            }
        },

        async storeOtout({ dispatch }, payload) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/api/otout', payload)
                .then((response) => {
                    return dispatch('setProfile', response.data)
                    //console.log(response.data)
                }).catch ((err) => {
                    throw err.response
                    // console.log(err)
                })
            } catch (e) {
                throw e
            }
        },

        async setProfile({ commit }, data) {
            commit('getProfile', data)
        }
    },
};
