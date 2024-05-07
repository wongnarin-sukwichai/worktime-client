
/** หน้าที่หลักๆของ Vuex คือการดึงข้อมูลจาก database จากนั้นเราก็นำข้อมูลที่ได้นั้นมาเตรียมข้อมูลไว้่ เพื่อให้เราสะดวกในการนำไปแสดงที่หน้าเว็บไซต์ผ่าน computed อีกที */

export default {
    //สร้างตัวแปรนั่นแหละ
    state() {
        return {
             edit: null,
        };
    },
    getters: {
        //getter เหมือนการสร้าง function ไว้รอเราเรียกใช้
        getTime(state) {
            return state.edit.timein
        }
    },
    mutations: {
        //mutaion รับค่าจาก action ผ่านคำสั่ง commit แล้วนำมาเปลี่ยนแปลงข้อมูลใน state (ด้านบน)
        getTimeEdit(state, payload) {
            state.edit = payload
        }
    },
    actions: {
        //action ส่วนในการคำนวณ ติดต่อข้อมูล api จาก backend ในที่นี้คือ axios ของ laravel นั่นเอง

        async updateIn({ dispatch }, payload) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/api/updatein', payload)
                .then((response) => {   
                    return dispatch('getEditTime', response.data)
                    // console.log(response.data)
                }).catch ((err) => {
                    throw err.response
                })
            } catch (e) {
                throw e
            }
        },

        async updateOut({ dispatch }, payload) {
            try {
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('/api/updateout', payload)
                .then((response) => {   
                    return dispatch('getEditTime', response.data)
                    // console.log(response.data)
                }).catch ((err) => {
                    throw err.response
                })
            } catch (e) {
                throw e
            }
        },

        async getEditTime({ commit }, data) {
            commit('getTimeEdit', data)
        }

    }
};
