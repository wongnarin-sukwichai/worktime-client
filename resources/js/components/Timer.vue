<template>
    <div class="flex justify-center p-8">
        <table class="table-auto border border-gray-300 text-sm">
            <thead class="border-b">
                <tr class="border-b">
                    <th colspan="2" class="p-4">
                        <box-icon
                            name="timer"
                            color="#fb923c"
                            size="md"
                        ></box-icon>
                        <p class="text-lg">แก้ไขเวลามาสาย</p>
                    </th>
                </tr>
                <tr>
                    <th
                        class="font-normal border-r p-4 text-center bg-sky-700 text-white"
                    >
                        เรื่อง
                    </th>
                    <th
                        class="font-normal p-4 text-center bg-sky-700 text-white"
                    >
                        รายละเอียด
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="p-4 border-r text-left">เวลาเดิม</td>
                    <td class="p-4 text-center">{{ this.dataEdit.timer }} น.</td>
                </tr>
                <tr class="border-b">
                    <td class="p-4 border-r text-left">เวลา</td>
                    <td class="flex p-4 text-left">
                        <input
                            type="text"
                            class="border p-2 text-gray-500"
                            v-model="this.dataEdit.timer"
                        />
                        <box-icon
                            name="revision"
                            size="sd"
                            color="#fff"
                            class="p-2 bg-green-300 hover:bg-green-400 hover:cursor-pointer"
                            @click="sendTimer()"
                        ></box-icon>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import "boxicons";
import Swal from "sweetalert2";
import axios from "axios";

export default {
    mounted() {
        this.getTimer();
    },
    data() {
        return {
            dataEdit: {
                id: "",
                timer: "",
            },
        };
    },
    methods: {
        getTimer() {
            axios
                .get("/api/timer")
                .then((response) => {

                    this.dataEdit.id = response.data.id
                    this.dataEdit.timer = response.data.timein;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        async sendTimer() {
            await this.$store.dispatch("updateTime", this.dataEdit);
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "บันทึกข้อมูลเรียบร้อย",
                showConfirmButton: false,
                timer: 1500,
            });
        },
    },
};
</script>
