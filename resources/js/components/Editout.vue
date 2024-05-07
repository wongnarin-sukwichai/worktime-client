<template>
    <div class="flex justify-center p-8">
        <table class="table-auto border border-gray-300 text-sm">
            <thead class="border-b">
                <tr class="border-b">
                    <th colspan="2" class="p-4">
                        <box-icon
                            name="log-out-circle"
                            color="#fdba74"
                            size="md"
                        ></box-icon>
                        <p class="text-lg">แก้ไขเวลาออก</p>
                    </th>
                </tr>
                <tr>
                    <th
                        class="font-normal border-r p-4 text-center bg-orange-400 text-white"
                    >
                        เรื่อง
                    </th>
                    <th
                        class="font-normal p-4 text-center bg-orange-400 text-white"
                    >
                        รายละเอียด
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="p-4 border-r text-left">รูป</td>
                    <td class="p-4 text-left">
                        <img
                            class="mx-auto rounded-full object-cover object-center h-16 w-16"
                            alt=""
                            :src="
                                path + '/' + y + '/' + m + '/' + d + '/' + pic
                            "
                        />
                    </td>
                </tr>
                <tr class="border-b">
                    <td class="p-4 border-r text-left">ชื่อ-นามสกุล</td>
                    <td class="p-4 text-left">
                        {{ this.name }} {{ this.surname }}
                    </td>
                </tr>
                <tr class="border-b">
                    <td class="p-4 border-r text-left">วันที่</td>
                    <td class="p-4 text-left">{{ this.dat }}</td>
                </tr>
                <tr class="border-b">
                    <td class="p-4 border-r text-left">
                        <font class="text-red-700 pr-1">**</font>หมายเหตุ
                    </td>
                    <td class="p-4 text-left">
                        <textarea
                            class="border p-2 w-full rounded-lg"
                            v-model="this.dataEdit.otherout"
                        ></textarea>
                    </td>
                </tr>
                <tr class="border-b">
                    <td class="p-4 border-r text-left">เวลา</td>
                    <td class="flex p-4 text-left">
                        <input
                            type="text"
                            class="border p-2"
                            v-model="this.dataEdit.timeout"
                        />
                        <box-icon
                            name="revision"
                            size="sd"
                            color="#fff"
                            class="p-2 bg-green-300 hover:bg-green-400 hover:cursor-pointer"
                            @click="sendEdit()"
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

export default {
    mounted() {
        this.getEdit();
    },
    data() {
        return {
            path: "/storage/img",
            pic: "",
            name: "",
            surname: "",
            dat: "",
            y: "",
            m: "",
            d: "",
            dataEdit: {
                id: "",
                timeout: "",
                otherout: "",
            },
        };
    },
    methods: {
        async getEdit() {
            await axios
                .get("/api/editout/" + this.$route.params.id)
                .then((response) => {
                    this.pic = response.data.pic;
                    this.name = response.data.name;
                    this.surname = response.data.surname;
                    this.dat = response.data.dat;
                    this.y = response.data.y;
                    this.m = response.data.m;
                    this.d = response.data.d;

                    this.dataEdit.id = response.data.id;
                    this.dataEdit.timeout = response.data.timeout;
                    this.dataEdit.otherout = response.data.otherout;
                })
                .catch((err) => {
                    console.log(err);
                });
        },

        async sendEdit() {
            if (this.dataEdit.otherin === "") {
                Swal.fire({
                    icon: "error",
                    title: "ผิดพลาด",
                    text: "กรุณาใส่หมายเหตุ",
                    timer: 1500,
                });
            } else {
                await this.$store.dispatch("updateOut", this.dataEdit);
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "บันทึกข้อมูลเรียบร้อย",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        },
    },
};
</script>
