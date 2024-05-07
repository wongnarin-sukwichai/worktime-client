<template>
    <div class="flex flex-col p-8">
        <div class="flex justify-end pb-2 no-print">
            <form class="flex">
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
            </form>
        </div>

        <div class="flex justify-end" v-if="showDayList">
            <button
                class="px-4 pt-1 border shadow-lg rounded-lg bg-slate-200 hover:bg-slate-300"
                @click.prevent="printReport()"
            >
                <box-icon name="printer"></box-icon>
            </button>
        </div>

        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8" ref="printRecord">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div
                    class="flex justify-left text-lg text-gray-400 mb-4"
                    v-if="showDayList"
                >
                    Print from the Worktime System Academic Resource Center MSU
                    |
                    {{ moment().add(543, "years").format("LLL") }} น.
                </div>

                <div class="overflow-hidden">
                    <table
                        class="min-w-full border text-center text-sm font-light"
                    >
                        <transition-group name="fade" mode="out-in">
                            <tbody
                                style="width: 100%; display: table"
                                v-if="showDayList"
                            >
                                <!-- Header -->
                                <thead class="border-b bg-sky-700 text-white">
                                    <tr>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            #
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            ชื่อ-นามสกุล
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            วันที่
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            #
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            เวลาเข้า
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            สถานะ
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            หมายเหตุ
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            #
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            เวลาออก
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r py-2 font-normal"
                                        >
                                            หมายเหตุ
                                        </th>
                                    </tr>
                                </thead>

                                <!-- กลุ่มงาน -->
                                <thead
                                    v-for="(dep, index) in depList"
                                    :key="index"
                                >
                                    <tr>
                                        <th
                                            colspan="10"
                                            class="border-b p-2 font-normal text-left bg-sky-100"
                                        >
                                            {{ dep.dep_title }}
                                        </th>
                                    </tr>

                                    <!-- รายชื่อ -->
                                    <tr
                                        class="border-b"
                                        v-for="(report, index) in showDayList"
                                        :key="index"
                                    >
                                        <template v-if="report.dep === dep.id">
                                            <td
                                                class="whitespace-nowrap border-r py-2"
                                            >
                                                {{ index + 1 }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap border-r py-2"
                                            >
                                                {{ report.name }}
                                                {{ report.surname }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap border-r py-2"
                                            >
                                                <!-- {{
                                                    moment(report.dat).add(543, "years").format(
                                                        "L"
                                                    )
                                                }} -->
                                                {{
                                                    moment(report.dat)
                                                        .add(543, "years")
                                                        .format("L")
                                                }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap border-r px-6 py-4"
                                            >
                                                <img
                                                    v-if="report.picin"
                                                    class="mx-auto rounded-full object-cover object-center h-8 w-8 cursor-pointer"
                                                    alt=""
                                                    :src="
                                                        path +
                                                        '/' +
                                                        report.y +
                                                        '/' +
                                                        report.m +
                                                        '/' +
                                                        report.d +
                                                        '/' +
                                                        report.picin
                                                    "
                                                    @click="
                                                        showImg(
                                                            report.y,
                                                            report.m,
                                                            report.d,
                                                            report.picin
                                                        )
                                                    "
                                                />
                                            </td>

                                            <td
                                                v-if="report.timein"
                                                class="whitespace-nowrap border-r py-2"
                                            >
                                                <a
                                                    class="hover:text-blue-500 hover:cursor-pointer"
                                                    @click="
                                                        editTime(
                                                            report.idin,
                                                            report.name,
                                                            report.surname,
                                                            report.dat,
                                                            report.timein,
                                                            report.otherin,
                                                            '1'
                                                        )
                                                    "
                                                >
                                                    {{ report.timein }}
                                                </a>
                                            </td>
                                            <td
                                                v-else
                                                class="border-r hover:cursor-pointer hover:bg-sky-100"
                                                @click="
                                                    addTime(
                                                        report.uid,
                                                        report.name,
                                                        report.surname,
                                                        report.dat,
                                                        '1'
                                                    )
                                                "
                                            ></td>
                                            <td
                                                class="whitespace-nowrap border-r py-2"
                                                :class="
                                                    report.timein > this.timer
                                                        ? 'bg-red-300'
                                                        : 'bg-gray-0'
                                                "
                                            >
                                                <span
                                                    class="text-white"
                                                    v-if="
                                                        report.timein >
                                                        this.timer
                                                    "
                                                    >มาสาย</span
                                                >
                                            </td>
                                            <td
                                                class="whitespace-nowrap border-r py-2"
                                            >
                                                {{ report.otherin }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap border-r px-6 py-4"
                                            >
                                                <img
                                                    v-if="report.picout"
                                                    class="mx-auto rounded-full object-cover object-center h-8 w-8 cursor-pointer"
                                                    alt=""
                                                    :src="
                                                        path +
                                                        '/' +
                                                        report.y +
                                                        '/' +
                                                        report.m +
                                                        '/' +
                                                        report.d +
                                                        '/' +
                                                        report.picout
                                                    "
                                                    @click="
                                                        showImg(
                                                            report.y,
                                                            report.m,
                                                            report.d,
                                                            report.picout
                                                        )
                                                    "
                                                />
                                            </td>

                                            <td
                                                v-if="report.timeout"
                                                class="whitespace-nowrap border-r py-2"
                                            >
                                                <a
                                                    class="hover:text-blue-500 hover:cursor-pointer"
                                                    @click.prevent="
                                                        editTime(
                                                            report.idout,
                                                            2
                                                        )
                                                    "
                                                >
                                                    {{ report.timeout }}
                                                </a>
                                            </td>
                                            <td
                                                v-else
                                                class="border-r hover:cursor-pointer hover:bg-sky-100"
                                                @click="
                                                    addTime(
                                                        report.uid,
                                                        report.name,
                                                        report.surname,
                                                        report.dat,
                                                        '2'
                                                    )
                                                "
                                            ></td>
                                            <td
                                                class="whitespace-nowrap border-r py-2"
                                            >
                                                {{ report.otherout }}
                                            </td>
                                        </template>
                                    </tr>
                                </thead>
                            </tbody>
                        </transition-group>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <transition name="fade" mode="out-in">
        <div
            class="relative z-10"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
            v-show="modalEdit"
        >
            <div
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            ></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div
                    class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
                >
                    <form
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                        @submit.prevent="sendEdit()"
                    >
                        <div
                            class="grid grid-cols-2 bg-white px-4 pb-4 sm:p-4 sm:pb-4"
                        >
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-amber-100 sm:mx-0 sm:h-10 sm:w-10"
                                >
                                    <box-icon name="user"></box-icon>
                                </div>
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >วันที่
                                    </label>
                                    <div
                                        class="border-dotted border-2 rounded-lg p-2"
                                    >
                                        {{
                                            moment(this.editData.dat)
                                                .add(543, "years")
                                                .format("L")
                                        }}
                                    </div>
                                </div>
                            </div>

                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >ชื่อ-นามสกุล :
                                    </label>
                                    <div
                                        class="border-dotted border-2 rounded-lg p-2"
                                    >
                                        {{ this.editData.name }}
                                        {{ this.editData.surname }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="grid grid-cols-2 bg-white px-4 pb-4 sm:p-4 sm:pb-4"
                        >
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-amber-100 sm:mx-0 sm:h-10 sm:w-10"
                                >
                                    <box-icon name="time"></box-icon>
                                </div>
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >เวลา :
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control block w-full px-3 py-1.5 rounded-lg text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-sky-300 focus:outline-none"
                                        placeholder="** 08:30:00 **"
                                        required
                                        v-model="editData.time"
                                    />
                                </div>
                            </div>

                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >หมายเหตุ :
                                    </label>
                                    <textarea
                                        class="border w-full rounded-lg p-2 focus:outline-none focus:ring-1 focus:border-blue-100"
                                        v-model="editData.other"
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
                        >
                            <button
                                type="submit"
                                class="inline-flex w-full justify-center rounded-md bg-amber-400 px-3 py-2 text-sm text-white shadow-sm hover:bg-amber-500 sm:ml-3 sm:w-auto"
                            >
                                แก้ไขข้อมูล
                            </button>
                            <button
                                type="button"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm text-gray-900 shadow-sm hover:bg-gray-50 ring-1 ring-inset ring-gray-300 sm:mt-0 sm:w-auto"
                                @click="closeEdit()"
                            >
                                ออก
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </transition>

    <!-- Modal Add -->
    <transition name="fade" mode="out-in">
        <div
            class="relative z-10"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
            v-show="modalAdd"
        >
            <div
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            ></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div
                    class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0"
                >
                    <form
                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg"
                        @submit.prevent="sendAdd()"
                    >
                        <div
                            class="grid grid-cols-2 bg-white px-4 pb-4 sm:p-4 sm:pb-4"
                        >
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-lime-100 sm:mx-0 sm:h-10 sm:w-10"
                                >
                                    <box-icon name="user"></box-icon>
                                </div>
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >วันที่
                                    </label>
                                    <div
                                        class="border-dotted border-2 rounded-lg p-2"
                                    >
                                        {{
                                            moment(this.addData.dat)
                                                .add(543, "years")
                                                .format("L")
                                        }}
                                    </div>
                                </div>
                            </div>

                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >ชื่อ-นามสกุล :
                                    </label>
                                    <div
                                        class="border-dotted border-2 rounded-lg p-2"
                                    >
                                        {{ this.addData.name }}
                                        {{ this.addData.surname }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="grid grid-cols-2 bg-white px-4 pb-4 sm:p-4 sm:pb-4"
                        >
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-lime-100 sm:mx-0 sm:h-10 sm:w-10"
                                >
                                    <box-icon name="time"></box-icon>
                                </div>
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >เวลา :
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control block w-full px-3 py-1.5 rounded-lg text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-sky-300 focus:outline-none"
                                        placeholder="** 08:30:00 **"
                                        required
                                        v-model="addData.time"
                                    />
                                </div>
                            </div>

                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full"
                                >
                                    <label
                                        id="listbox-label"
                                        class="block text-sm font-medium leading-6 text-gray-900"
                                        >หมายเหตุ :
                                    </label>
                                    <textarea
                                        class="border w-full rounded-lg p-2 focus:outline-none focus:ring-1 focus:border-blue-100"
                                        v-model="addData.other"
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        <div
                            class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6"
                        >
                            <button
                                type="submit"
                                class="inline-flex w-full justify-center rounded-md bg-green-400 px-3 py-2 text-sm text-white shadow-sm hover:bg-green-500 sm:ml-3 sm:w-auto"
                            >
                                บันทึกข้อมูล
                            </button>
                            <button
                                type="button"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm text-gray-900 shadow-sm hover:bg-gray-50 ring-1 ring-inset ring-gray-300 sm:mt-0 sm:w-auto"
                                @click="closeAdd()"
                            >
                                ออก
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
import "boxicons";
import Datepicker from "vue3-datepicker";
import moment from "moment";
import axios from "axios";
import html2canvas from "html2canvas";
import { jsPDF } from "jspdf";
import Swal from "sweetalert2";

export default {
    mounted() {
        this.search();
        this.getDep();
        this.getTimer();
    },
    data() {
        return {
            logo: "/img/library.png",
            path: "/storage/img",
            picked: new Date(),
            show: true,
            modalEdit: false,
            modalAdd: false,
            report: {
                selected: "",
            },
            showDayList: "",
            depList: "",
            moment: moment,
            timer: "",
            editData: {
                id: "",
                name: "",
                surname: "",
                dat: "",
                time: "",
                other: "",
                code: "",
            },
            addData: {
                uid: "",
                name: "",
                surname: "",
                dat: "",
                time: "08:30:00",
                other: "",
                code: ""
            },
        };
    },
    methods: {
        async search() {
            this.report.selected = moment(this.picked)
                //.add(543, "years")
                .format("YYYY-MM-DD");
            // console.log(this.selected)
            try {
                await this.$store.dispatch("reportDay", this.report);
                this.showDayList = this.$store.getters.reportDay;
            } catch (err) {
                console.log(err);
            }
        },
        getDep() {
            axios
                .get("/api/dep")
                .then((response) => {
                    this.depList = response.data;
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
        editTime(id, name, surname, dat, time, other, code) {
            this.editData.id = id;
            this.editData.name = name;
            this.editData.surname = surname;
            this.editData.dat = dat;
            this.editData.time = time;
            this.editData.other = other;
            this.editData.code = code;

            this.modalEdit = true;
        },
        closeEdit() {
            this.modalEdit = false;
        },
        async sendEdit() {
            try {
                await axios
                    .put("/api/edit/" + this.editData.id, this.editData)
                    .then((response) => {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        this.modalEdit = false;
                        this.search();
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            } catch (err) {
                console.log(err);
            }
        },
        addTime(id, name, surname, dat, code) {
            this.addData.uid = id;
            this.addData.name = name;
            this.addData.surname = surname;
            this.addData.dat = dat;
            this.addData.code = code;

            this.modalAdd = true;
        },
        closeAdd() {
            this.modalAdd = false;
        },
        async sendAdd() {
            try {
                axios
                    .post("/api/add", this.addData)
                    .then((response) => {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: 1500,
                        });
                        this.modalAdd = false;
                        this.search();
                    })
                    .catch((err) => {
                        console.log(err);
                    });
            } catch (err) {
                console.log(err);
            }
        },
        async printReport() {
            var dom = this.$refs.printRecord; //'tabalo' is an Id in my to-do list table
            html2canvas(dom).then(function (canvas) {
                var imgData = canvas.toDataURL("image/png");
                // var imgWidth = 210;
                // var pageHeight = 290;
                var imgWidth = 280;
                var pageHeight = 300;
                var imgHeight = (canvas.height * imgWidth) / canvas.width;
                var heightLeft = imgHeight;
                var doc = new jsPDF("p", "mm", "A4");
                var position = 0; // give some top padding to first page

                doc.addImage(imgData, "PNG", 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                while (heightLeft >= 0) {
                    position += heightLeft - imgHeight; // top padding for other pages
                    doc.addPage();
                    doc.addImage(
                        imgData,
                        "PNG",
                        0,
                        position,
                        imgWidth,
                        imgHeight
                    );
                    heightLeft -= pageHeight;
                }
                doc.save("file.pdf");
            });
        },
        showImg(y, m, d, pic) {
            window.open(
                "/storage/img/" + y + "/" + m + "/" + d + "/" + pic,
                "_blank"
            );
        },
    },
    components: {
        Datepicker,
    },
};
</script>

<style>
.boxplus:hover {
    color: red;
}
</style>
