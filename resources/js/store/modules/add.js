
/** หน้าที่หลักๆของ Vuex คือการดึงข้อมูลจาก database จากนั้นเราก็นำข้อมูลที่ได้นั้นมาเตรียมข้อมูลไว้่ เพื่อให้เราสะดวกในการนำไปแสดงที่หน้าเว็บไซต์ผ่าน computed อีกที */

export default {
    //สร้างตัวแปรนั่นแหละ
    state() {
        return {
             add: null,
        };
    },
    getters: {
        //getter เหมือนการสร้าง function ไว้รอเราเรียกใช้
        getAddIn(state) {
            return state.add.timein
        },
        getAddOut(state) {
            return state.add.timeout
        }
    },
    mutations: {
        //mutaion รับค่าจาก action ผ่านคำสั่ง commit แล้วนำมาเปลี่ยนแปลงข้อมูลใน state (ด้านบน)
        getAddTime(state, payload) {
            state.add = payload
        }
    },
    actions: {
        //action ส่วนในการคำนวณ ติดต่อข้อมูล api จาก backend ในที่นี้คือ axios ของ laravel นั่นเอง

        async addIn({ dispatch }, payload) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/api/addin', payload)
                .then((response) => {   
                    return dispatch('getAdd', response.data)
                    // console.log(response.data)
                }).catch ((err) => {
                    throw err.response
                })
            } catch (e) {
                throw e
            }
        },

        async addOut({ dispatch }, payload) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/api/addout', payload)
                .then((response) => {   
                    return dispatch('getAdd', response.data)
                    // console.log(response.data)
                }).catch ((err) => {
                    throw err.response
                })
            } catch (e) {
                throw e
            }
        },

        async getAdd({ commit }, data) {
            commit('getAddTime', data)
        }

    }
};
