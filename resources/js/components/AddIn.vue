<template>
    <div class="flex justify-center p-8">
        <table class="table-auto border border-gray-300 text-sm">
            <thead class="border-b">
                <tr class="border-b">
                    <th colspan="2" class="p-4">
                        <box-icon
                            name="plus-circle"
                            color="#4ade80"
                            size="md"
                        ></box-icon>
                        <p class="text-lg">เพิ่มเวลาเข้า</p>
                    </th>
                </tr>
                <tr>
                    <th
                        class="font-normal border-r p-4 text-center bg-green-400 text-white"
                    >
                        เรื่อง
                    </th>
                    <th
                        class="font-normal p-4 text-center bg-green-400 text-white"
                    >
                        รายละเอียด
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="p-4 border-r text-left">รูป</td>
                    <td class="p-4 text-left bg-gray-300">
                    </td>
                </tr>
                <tr class="border-b">
                    <td class="p-4 border-r text-left">ชื่อ-นามสกุล</td>
                    <td class="p-4 text-left">{{ this.dataIn.name }} {{ this.dataIn.surname }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-4 border-r text-left">วันที่</td>
                    <td class="p-4 text-left">{{ moment(this.dataIn.dat).format('L') }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-4 border-r text-left">
                        <font class="text-red-700 pr-1">**</font>หมายเหตุ
                    </td>
                    <td class="p-4 text-left">
                        <textarea
                            class="border p-2 w-full rounded-lg"
                            v-model="this.dataIn.other"
                        ></textarea>
                    </td>
                </tr>
                <tr class="border-b">
                    <td class="p-4 border-r text-left">เวลา</td>
                    <td class="flex p-4 text-left">
                        <input
                            type="text"
                            class="border p-2"
                            v-model="this.dataIn.timein"
                        />
                        <box-icon
                            name="plus"
                            size="sd"
                            color="#fff"
                            class="p-2 bg-green-300 hover:bg-green-400 hover:cursor-pointer"
                            @click="sendAdd()"
                        ></box-icon>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import "boxicons";
import axios from "axios";
import Swal from "sweetalert2";
import moment from "moment";
import "moment/dist/locale/th";

export default {
    mounted() {
        this.getName();
    },
    data() {
        return {
            dataIn: {
                uid: this.$route.params.uid,
                name: "",
                surname: "",
                dat: this.$route.params.dat,
                timein: "00:00:00",
                other: ""
            },
            moment: moment
        };
    },
    methods: {
        async getName() {
            await axios
                .get("/api/showname/" + this.$route.params.uid)
                .then((response) => {
                    this.dataIn.name = response.data.name;
                    this.dataIn.surname = response.data.surname;
                })
                .catch((err) => {
                    console.log(err);
                });
        },

        async sendAdd() {
            await this.$store.dispatch("addIn", this.dataIn);
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
