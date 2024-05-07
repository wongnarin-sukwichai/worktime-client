<template>
    <div class="p-16 bg-gradient-to-r from-blue-400 to-emerald-400">
        <div class="p-8 bg-white shadow-lg mt-24">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <div
                    class="grid grid-cols-3 text-center order-last md:order-first mt-20 md:mt-0"
                >
                    <div>
                        <div id="digit_clock_date" class="font-semibold"></div>
                        <p class="text-gray-300 text-4xl">ว/ด/ป</p>
                    </div>
                </div>

                <div class="relative">
                    <div
                        class="w-72 h-72 bg-indigo-100 mx-auto rounded-full shadow-2xl absolute inset-x-0 top-0 -mt-40 flex items-center justify-center text-indigo-500"
                    >
                        <video
                            ref="webcam"
                            autoplay="true"
                            class="rounded-full w-72 h-72 mx-auto"
                        ></video>
                    </div>
                </div>

                <!-- component -->
                <div class="space-y-5">
                    <div
                        class="overflow-hidden rounded-xl border border-gray-100 bg-gray-50 p-1"
                    >
                        <ul class="flex items-center gap-2 text-sm font-medium">
                            <li class="flex-1">
                                <router-link
                                    to="/"
                                    class="text-white relative flex items-center justify-center gap-2 rounded-lg bg-emerald-300 px-3 py-2 shadow hover:bg-emerald-400"
                                >
                                    เข้างาน</router-link
                                >
                            </li>
                            <li class="flex-1">
                                <router-link
                                    to="checkout"
                                    class="flex items-center justify-center gap-2 rounded-lg px-3 py-2 text-gray-500 hover:bg-orange-300 hover:text-white hover:shadow"
                                >
                                    ออกงาน</router-link
                                >
                            </li>
                            <li class="flex-1">
                                <router-link
                                    to="otin"
                                    class="flex items-center justify-center gap-2 rounded-lg px-3 py-2 text-gray-500 hover:bg-sky-300 hover:text-white hover:shadow"
                                >
                                    เข้างาน OT</router-link
                                >
                            </li>
                            <li class="flex-1">
                                <router-link
                                    to="otout"
                                    class="flex items-center justify-center gap-2 rounded-lg px-3 py-2 text-gray-500 hover:bg-pink-300 hover:text-white hover:shadow"
                                >
                                    ออกงาน OT</router-link
                                >
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="absolute mt-20">
                    <div
                        class="flex py-2"
                        v-for="(rec, index) in recordList"
                        :key="index"
                    >
                        <div
                            class="flex justify-center items-center border-dotted border-2 border-sky-300 rounded-lg p-1 ml-2"
                        >
                            <box-icon name="chevrons-up"></box-icon>
                        </div>
                        <div
                            class="border-dotted border-2 border-sky-300 rounded-lg p-2 ml-2"
                        >
                            {{ rec.name }} {{ rec.surname }}
                        </div>
                        <div
                            class="border-dotted border-2 border-sky-300 rounded-lg p-2 ml-2"
                        >
                            {{ rec.time }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-20 text-center pb-4">
                <h1 class="text-4xl font-medium text-gray-700">
                    {{ this.profile }}
                </h1>
                <p class="font-light text-gray-600 mt-3"></p>
                <p class="mt-8 text-gray-500"></p>
                <p class="mt-2 text-gray-500 text-xl">
                    สำนักวิทยบริการ มหาวิทยาลัยมหาสารคาม
                </p>
            </div>

            <div class="flex flex-wrap justify-center mt-4">
                <div class="flex justify-center px-4">
                    <p class="px-4 pt-5 mr-2 text-2xl">Lates :</p>
                    <canvas
                        class="rounded-full border shadow-lg"
                        ref="showCapture"
                        :width="80"
                        :height="80"
                    ></canvas>
                    <p
                        class="px-3 pt-5 ml-2 border rounded-full shadow-lg text-2xl"
                    >
                        {{ this.profile }}
                    </p>
                    <p
                        class="px-3 pt-5 ml-2 border rounded-full shadow-lg text-2xl"
                    >
                        {{ this.timein }}
                    </p>
                </div>
            </div>

            <form class="mt-8" @submit.prevent="sendData()">
                <div class="relative mb-4 flex flex-wrap items-stretch">
                    <input
                        type="text"
                        class="relative h-28 text-6xl text-sky-700 m-0 -ml-0.5 block w-[1px] min-w-0 flex-auto rounded-lg border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] leading-[1.6] outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none"
                        aria-label="Example text with button addon"
                        aria-describedby="button-addon1"
                        style="text-align: center"
                        autofocus
                        v-model="record.uid"
                    />
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Swal from "sweetalert2";
import "boxicons";

export default {
    mounted() {
        this.startWebcam();
    },
    data() {
        return {
            image: "/img/library.jpg",
            formData: "",
            imageCapture: "",
            record: {
                uid: "",
                capture: "",
            },
            profile: "",
            timein: "",
            recordList: [],
        };
    },
    methods: {
        async sendData() {
            let formData = new FormData();

            try {
                await this.imageCapture.takePhoto().then((blob) => {
                    formData.append("file", blob);
                });

                await this.$store.dispatch("storeUpload", formData);

                this.record.capture = this.$store.getters.getImageName;
            } catch (err) {
                console.log("Something went wrong vue : ", err);
            }

            try {
                await this.$store.dispatch("storeCheckin", this.record);

                //cap หน้าจอแล้วแสดงภาพ
                const context = this.$refs.showCapture.getContext("2d");
                context.drawImage(this.$refs.webcam, 0, 0, 80, 80);

                // console.log(this.profileName())

                if (this.recordList.length <= 4) {
                    this.recordList.push({
                        name: this.profileName(),
                        time: this.timeIn(),
                    });
                } else {
                    this.recordList.splice(0, 1);
                    this.recordList.push({
                        name: this.profileName(),
                        time: this.timeIn(),
                    });
                }

                this.profile = this.profileName();
                this.timein = this.timeIn();

            } catch (err) {

                this.profile = '';
                this.timein = '';

                Swal.fire({
                    icon: "error",
                    title: "ผิดพลาด",
                    text: "กรุณาตรวจสอบการเชื่อมต่ออินเตอร์เน็ต และ รหัส",
                    timer: 1500,
                });
                // console.log("Something went wrong store : ", err);
            }

            this.record.uid = "";
            this.record.capture = "";
        },

        startWebcam() {
            if (navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices
                    .getUserMedia({
                        video: true,
                    })
                    .then((stream) => {
                        this.$refs.webcam.srcObject = stream; //เปิด webcam
                        this.imageCapture = new ImageCapture(
                            stream.getVideoTracks()[0]
                        );
                    })
                    .catch((err) => {
                        console.log("Something went wrong", err);
                    });
            }
        },

        profileName() {
            return this.$store.getters.getProfileName;
        },

        timeIn() {
            return this.$store.getters.getTimeIn + " น.";
        },
    },
};
</script>
