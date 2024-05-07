<template>
    <div class="p-16 bg-gray-50">
        <div class="grid grid-cols-6 gap-2">
            <div
                class="p-6 rounded-md bg-white bg-opacity-50 lg:w-60 border rounded-lg shadow-lg no-print"
            >
                <nav class="space-y-4 text-sm text-gray-700">
                    <div class="space-y-2">
                        <h2
                            class="text-lg font-semibold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600"
                        >
                            Home
                        </h2>
                        <div class="flex flex-col space-y-2">
                            <router-link
                                to="/home"
                                class="flex p-2 rounded-lg hover:bg-gray-100 hover:text-gray-700"
                                ><box-icon
                                    name="calendar-check"
                                    color="gray"
                                    size="sm"
                                    class="pr-2"
                                ></box-icon>
                                <p class="p-1">รายวัน</p></router-link
                            >
                            <router-link
                                to="/member"
                                class="flex p-2 rounded-lg hover:bg-gray-100 hover:text-gray-700"
                                ><box-icon
                                    name="user-check"
                                    color="gray"
                                    size="sm"
                                    class="pr-2"
                                ></box-icon>
                                <p class="p-1">รายบุคคล</p></router-link
                            >
                            <router-link
                                to="/record"
                                class="flex p-2 rounded-lg hover:bg-gray-100 hover:text-gray-700"
                                ><box-icon
                                    name="table"
                                    color="gray"
                                    size="sm"
                                    class="pr-2"
                                ></box-icon>
                                <p class="p-1">รายงานการแก้ไข</p></router-link
                            >
                            <router-link
                                to="/timer"
                                class="flex p-2 rounded-lg hover:bg-gray-100 hover:text-gray-700"
                                ><box-icon
                                    name="timer"
                                    color="gray"
                                    size="sm"
                                    class="pr-2"
                                ></box-icon>
                                <p class="p-1">ตั้งค่าเวลามาสาย</p></router-link
                            >
                        </div>
                    </div>
                    <div class="space-y-2">
                        <h2
                            class="text-lg font-semibold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600"
                        >
                            Tools
                        </h2>
                        <div class="flex flex-col space-y-1">
                            <div
                                class="flex p-2 rounded-lg hover:bg-gray-100 hover:text-gray-700 cursor-pointer"
                                @click="link()"
                            >
                                <box-icon
                                    name="file"
                                    color="gray"
                                    size="sm"
                                    class="pr-2"
                                ></box-icon>
                                <p class="p-1">คู่มือการใช้งาน</p>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <h2
                            class="text-lg font-semibold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-600"
                        >
                            System
                        </h2>
                        <div class="flex flex-col space-y-1 cursor-pointer">
                            <div
                                class="flex p-2 rounded-lg hover:bg-gray-100 hover:text-gray-700"
                                @click="logout()"
                            >
                                <box-icon
                                    name="log-out-circle"
                                    color="red"
                                    size="sm"
                                    class="pr-2"
                                ></box-icon>
                                <p class="p-1">ออกจากระบบ</p>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <div
                class="col-span-5 bg-white border rounded-md bg-opacity-50 shadow-lg"
            >
                <router-view />
            </div>
        </div>
    </div>
</template>

<script>
import "boxicons";

export default {
    mounted() {},
    methods: {
        async logout() {
            await this.$store.dispatch("logout");
            this.$router.push({ name: "login" });
        },
        link() {
            window.open("/pdf/tools.pdf", "_blank");
        }
    },
};
</script>
