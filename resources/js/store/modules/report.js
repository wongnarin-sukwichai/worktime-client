
/** หน้าที่หลักๆของ Vuex คือการดึงข้อมูลจาก database จากนั้นเราก็นำข้อมูลที่ได้นั้นมาเตรียมข้อมูลไว้่ เพื่อให้เราสะดวกในการนำไปแสดงที่หน้าเว็บไซต์ผ่าน computed อีกที */

export default {
    //สร้างตัวแปรนั่นแหละ
    state() {
        return {
             daylist: null,
             memberlist: null
        };
    },
    getters: {
        //getter เหมือนการสร้าง function ไว้รอเราเรียกใช้
        reportDay(state) {
            return state.daylist;
        },
        reportMember(state) {
            return state.memberlist;
        }
    },
    mutations: {
        //mutaion รับค่าจาก action ผ่านคำสั่ง commit แล้วนำมาเปลี่ยนแปลงข้อมูลใน state (ด้านบน)
        setDay(state, payload) {
            state.daylist = payload
        },

        setMember(state, payload) {
            state.memberlist = payload
        }
    },
    actions: {
        //action ส่วนในการคำนวณ ติดต่อข้อมูล api จาก backend ในที่นี้คือ axios ของ laravel นั่นเอง

        async reportDay({ dispatch }, payload) {
            //async มาคู่กับ await เสมอ | dispatch เป็นการรับข้อมูลจาก function จาก .vue ในที่นี้รับจาก Login.vue
            //console.log(payload);
            try {
                await axios.get("/sanctum/csrf-cookie"); //await การ process ข้อมูลโดยบังคับให้ต้องรอ กระบวนการนี้เสร็จก่อนจึงจะสามารถไปทำ process อื่นๆได้

                await axios
                    .post("/api/reportDay", payload) //ไปที่ routes->api
                    .then((response) => {
                        return dispatch("getDay", response.data);
                    })
                    .catch((err) => {
                        throw err.response;
                    });
            } catch (e) {
                throw e;
            }
        },

        async getDay({ commit }, data) {
            commit('setDay', data)
        },

        async reportMember({ dispatch }, payload) {
            //async มาคู่กับ await เสมอ | dispatch เป็นการรับข้อมูลจาก function จาก .vue ในที่นี้รับจาก Login.vue
            //console.log(payload);
            try {
                await axios.get("/sanctum/csrf-cookie"); //await การ process ข้อมูลโดยบังคับให้ต้องรอ กระบวนการนี้เสร็จก่อนจึงจะสามารถไปทำ process อื่นๆได้

                await axios
                    .post("/api/reportMember", payload) //ไปที่ routes->api
                    .then((response) => {
                        return dispatch("getMember", response.data);
                    })
                    .catch((err) => {
                        throw err.response;
                    });
            } catch (e) {
                throw e;
            }
        },

        async getMember({ commit }, data) {
            commit('setMember', data)
        },

    },
};
