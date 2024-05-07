

/** หน้าที่หลักๆของ Vuex คือการดึงข้อมูลจาก database จากนั้นเราก็นำข้อมูลที่ได้นั้นมาเตรียมข้อมูลไว้่ เพื่อให้เราสะดวกในการนำไปแสดงที่หน้าเว็บไซต์ผ่าน computed อีกที */

export default {
    //สร้างตัวแปรนั่นแหละ
    state() {

    },
    getters: {
      
    },
    mutations: {
        //mutaion รับค่าจาก action ผ่านคำสั่ง commit แล้วนำมาเปลี่ยนแปลงข้อมูลใน state (ด้านบน)
    },
    actions: {
        //action ส่วนในการคำนวณ ติดต่อข้อมูล api จาก backend ในที่นี้คือ axios ของ laravel นั่นเอง

        async updateTime({ dispatch }, payload) {
            try {
                await axios.get("/sanctum/csrf-cookie");
                await axios
                    .put("/api/timer/" + payload.id, payload)
                    .then((response) => {
                       
                    })
                    .catch((err) => {
                        throw err.response;
                    });
            } catch (e) {
                throw e;
            }
        },
    },
};
