

/** หน้าที่หลักๆของ Vuex คือการดึงข้อมูลจาก database จากนั้นเราก็นำข้อมูลที่ได้นั้นมาเตรียมข้อมูลไว้่ เพื่อให้เราสะดวกในการนำไปแสดงที่หน้าเว็บไซต์ผ่าน computed อีกที */

export default {
    //สร้างตัวแปรนั่นแหละ
    state() {
        return {
             imageName: null,
        };
    },
    getters: {
        //getter เหมือนการสร้าง function ไว้รอเราเรียกใช้
        getImageName(state) {
            return state.imageName
        }
    },
    mutations: {
        //mutaion รับค่าจาก action ผ่านคำสั่ง commit แล้วนำมาเปลี่ยนแปลงข้อมูลใน state (ด้านบน)
        setImageName(state, payload) {
            state.imageName = payload
        }
    },
    actions: {
        //action ส่วนในการคำนวณ ติดต่อข้อมูล api จาก backend ในที่นี้คือ axios ของ laravel นั่นเอง

        async storeUpload({ dispatch }, payload) {

            const config = {                                    //ใส่ทุกครั้งที่รับ File เข้ามา
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            try {
                await axios.get('/sanctum/csrf-cookie')
                await axios.post('http://202.28.32.106:8081/api/upload', payload, config)
                .then((response) => {
                    return dispatch('getImageName', response.data)
                    //console.log(response.data)
                }).catch ((err) => {
                    console.log('Something went wrong vuex', err)
                })
            } catch (e) {
                throw e
            }
        },

        async getImageName({ commit }, data) {
            commit('setImageName', data)
        }
    },
};
