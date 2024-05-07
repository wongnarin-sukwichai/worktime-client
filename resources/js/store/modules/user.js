/** หน้าที่หลักๆของ Vuex คือการดึงข้อมูลจาก database จากนั้นเราก็นำข้อมูลที่ได้นั้นมาเตรียมข้อมูลไว้่ เพื่อให้เราสะดวกในการนำไปแสดงที่หน้าเว็บไซต์ผ่าน computed อีกที */

export default {
    //สร้างตัวแปรนั่นแหละ
    state() {
        return {
            user: null,
        };
    },
    getters: {
        //getter เหมือนการสร้าง function ไว้รอเราเรียกใช้
        user(state) {
            return state.user;
        },
        id(state) {
            if (state.user) return state.user.id;
            return null;
        },
        fullname(state) {
            return state.user.name + " " + state.user.surname;
        },
        authEmail(state) {
            return state.user.email;
        },
        getRules(state) {
            return state.user.system;
        },
    },
    mutations: {
        //mutaion รับค่าจาก action ผ่านคำสั่ง commit แล้วนำมาเปลี่ยนแปลงข้อมูลใน state (ด้านบน)

        setUser(state, payload) {
            state.user = payload;
        },
        setAuthen(state, payload) {
            state.authenticated = payload;
        },
    },
    actions: {
        //action ส่วนในการคำนวณ ติดต่อข้อมูล api จาก backend ในที่นี้คือ axios ของ laravel นั่นเอง

        async login({ dispatch }, payload) {
            //async มาคู่กับ await เสมอ | dispatch เป็นการรับข้อมูลจาก function จาก .vue ในที่นี้รับจาก Login.vue
            //console.log(payload);
            try {
                await axios.get("/sanctum/csrf-cookie"); //await การ process ข้อมูลโดยบังคับให้ต้องรอ กระบวนการนี้เสร็จก่อนจึงจะสามารถไปทำ process อื่นๆได้

                await axios
                    .post("/api/login", payload) //ไปที่ routes->api->login
                    .then((response) => {
                        return dispatch("getUser");
                    })
                    .catch((err) => {
                        throw err.response;
                    });
            } catch (e) {
                throw e;
            }
        },

        async logout({ commit }) {
            await axios.get("/sanctum/csrf-cookie");
            await axios
                .post("/api/logout")
                .then((response) => {
                    // console.log(response)
                    commit("setUser", null);
                    commit("setAuthen", false);
                })
                .catch((err) => {
                    // console.log("ERROR::",err.response.headers)
                });
        },

        async getUser({ commit }) {
            await axios
                .get("/api/user")
                .then((response) => {
                    commit("setUser", response.data); //commit คำสั่งเปลี่ยนแปลงข้อมูลใน mutation จากตัวอย่างหมายถึง mutaion function ชื่อ setUser (เลื่อนขึ้นไปดูข้างบน)
                })
                .catch((err) => {
                    throw err.response;
                });
        },
    },
};
