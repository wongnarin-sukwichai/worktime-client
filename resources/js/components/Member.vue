<template>
    <div class="flex flex-col p-8">
        <div class="flex justify-end pb-2 no-print">
            <button
                type="button"
                class="w-80 border rounded-lg p-2 mr-2 text-right"
                @click="showSelect = !showSelect"
            >
                {{ this.myname }}
                <box-icon
                    name="chevron-down"
                    size="xs"
                    class="hover:cursor-pointer"
                ></box-icon>

                <transition name="fade" mode="out-in">
                    <ul
                        class="absolute z-10 border rounded-lg mt-4 p-2 overflow-hidden w-80 -mx-2 bg-white"
                        v-if="showSelect"
                    >
                        <li
                            class="hover:bg-sky-400 hover:text-white rounded-lg"
                            v-for="(member, index) in memberList"
                            :key="index"
                            @click="
                                choose(member.uid, member.name, member.surname)
                            "
                        >
                            {{ member.name }} {{ member.surname }}
                        </li>
                    </ul>
                </transition>
            </button>

            <Datepicker
                class="hover:cursor-pointer border rounded-lg p-2 text-right"
                language="th"
                v-model="picked"
            />
            <button
                class="rounded-lg border ml-2 p-2 bg-green-200 hover:bg-green-300"
                @click.prevent="search()"
            >
                ค้นหา
            </button>
        </div>
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <table
                        class="min-w-full border text-center text-sm font-light"
                    >
                        <transition-group name="fade" mode="out-in">
                            <tbody
                                style="width: 100%; display: table"
                                v-if="showMemberList"
                            >
                                <!-- Header -->
                                <thead class="border-b bg-sky-700 text-white">
                                    <tr>
                                        <th
                                            scope="col"
                                            class="border-r px-6 py-2 font-normal"
                                        >
                                            #
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r px-6 py-2 font-normal"
                                        >
                                            ชื่อ-นามสกุล
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r px-6 py-2 font-normal"
                                        >
                                            วันที่
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r px-6 py-2 font-normal"
                                        >
                                            #
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r px-6 py-2 font-normal"
                                        >
                                            เวลาเข้า
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r px-6 py-2 font-normal"
                                        >
                                            สถานะ
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r px-6 py-2 font-normal"
                                        >
                                            หมายเหตุ
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r px-6 py-2 font-normal"
                                        >
                                            #
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r px-6 py-2 font-normal"
                                        >
                                            เวลาออก
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r px-6 py-2 font-normal"
                                        >
                                            หมายเหตุ
                                        </th>
                                    </tr>
                                </thead>

                                <!-- กลุ่มงาน -->
                                <thead>
                                    <!-- รายชื่อ -->
                                    <tr
                                        class="border-b"
                                        v-for="(
                                            report, index
                                        ) in showMemberList"
                                        :key="index"
                                    >
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            {{ index }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            {{ report.name }}
                                            {{ report.surname }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            {{
                                                moment(report.dat)
                                                    .add(543, "years")
                                                    .format("L")
                                            }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            <img
                                                v-if="report.picin"
                                                class="mx-auto rounded-full object-cover object-center h-10 w-10"
                                                alt=""
                                                :src="
                                                    path +
                                                    '/' +
                                                    report.y +
                                                    '/' +
                                                    report.m +
                                                    '/' +
                                                    report.din +
                                                    '/' +
                                                    report.picin
                                                "
                                            />
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            <a
                                                class="hover:text-blue-500 hover:cursor-pointer"
                                                @click.prevent="
                                                    editIn(report.idin)
                                                "
                                            >
                                                {{ report.timein }}
                                            </a>
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                            :class="
                                                report.timein > this.timer
                                                    ? 'bg-red-300'
                                                    : 'bg-gray-0'
                                            "
                                        >
                                            <span
                                                class="text-white"
                                                v-if="
                                                    report.timein > this.timer
                                                "
                                                >มาสาย</span
                                            >
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            {{ report.otherin }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            <img
                                                v-if="report.picout"
                                                class="mx-auto rounded-full object-cover object-center h-10 w-10"
                                                alt=""
                                                :src="
                                                    path +
                                                    '/' +
                                                    report.y +
                                                    '/' +
                                                    report.m +
                                                    '/' +
                                                    report.dout +
                                                    '/' +
                                                    report.picout
                                                "
                                            />
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            <a
                                                class="hover:text-blue-500 hover:cursor-pointer"
                                                @click.prevent="
                                                    editOut(report.idout)
                                                "
                                            >
                                                {{ report.timeout }}
                                            </a>
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            {{ report.otherout }}
                                        </td>
                                    </tr>
                                </thead>
                            </tbody>
                        </transition-group>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import "boxicons";
import Datepicker from "vue3-datepicker";
import moment from "moment";
import axios from "axios";
import Swal from "sweetalert2";

export default {
    mounted() {
        this.getMember();
        this.getTimer();
    },
    data() {
        return {
            path: "/storage/img",
            picked: new Date(),
            show: true,
            showSelect: false,
            myname: "",
            report: {
                uid: "",
                selected: "",
            },
            showMemberList: "",
            memberList: "",
            moment: moment,
            timer: "",
        };
    },
    methods: {
        async search() {
            if (this.report.uid == "") {
                Swal.fire({
                    title: "ไม่มีข้อมูล",
                    text: "กรุณาเลือกบุคลากรที่ต้องการ",
                    icon: "error",
                });
            } else {
                this.report.selected = moment(this.picked)
                    // .add(543, "years")
                    .format("YYYY-MM-DD");
                // console.log(this.selected)
                try {
                    await this.$store.dispatch("reportMember", this.report);
                    this.showMemberList = this.$store.getters.reportMember;
                } catch (err) {
                    console.log(err);
                }
            }
        },
        getMember() {
            axios
                .get("/api/member")
                .then((response) => {
                    this.memberList = response.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        getTimer() {
            axios
                .get("/api/timer")
                .then((response) => {
                    this.timer = response.data.timein;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        choose(id, name, surname) {
            this.report.uid = id;
            this.myname = name + " " + surname;
        },
        editIn(id) {
            this.$router.push("/editin/" + id);
        },
        editOut(id) {
            this.$router.push("/editout/" + id);
        },
    },
    components: {
        Datepicker,

        myname() {
            return this.myname;
        },
    },
};
</script>
