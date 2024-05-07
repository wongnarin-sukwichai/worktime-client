<template>
    <div class="flex flex-col p-8">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
                <div class="flex justify-center pb-8 no-print">
                    <h1 class="text-2xl text-sky-600 italic">รายงานการแก้ไข</h1>
                </div>
                <div class="overflow-hidden">
                    <table
                        class="min-w-full border text-center text-sm font-light"
                    >
                        <transition-group name="fade" mode="out-in">
                            <tbody style="width: 100%; display: table">
                                <!-- Header -->
                                <thead class="border-b bg-teal-500 text-white">
                                    <tr>
                                        <th
                                            scope="col"
                                            class="border-r px-6 py-2 font-normal"
                                        >
                                            วันที่แก้ไข
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r px-6 py-2 font-normal"
                                        >
                                            เวลา
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r px-6 py-2 font-normal"
                                        >
                                            แก้ไขโดย
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r px-6 py-2 font-normal"
                                        ></th>
                                        <th
                                            scope="col"
                                            class="border-r px-6 py-2 font-normal"
                                        >
                                            ID
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
                                            ประเภท
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
                                            เวลาเดิม
                                        </th>
                                        <th
                                            scope="col"
                                            class="border-r px-6 py-2 font-normal"
                                        >
                                            เวลาใหม่
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
                                            record, index
                                        ) in recordList.data"
                                        :key="index"
                                    >
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            {{
                                                moment(record.created_at)
                                                    .add(543, "years")
                                                    .format("L")
                                            }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            {{
                                                moment(
                                                    record.created_at
                                                ).format("LTS")
                                            }}
                                            น.
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2 text-sky-500"
                                        >
                                            {{ record.created_by }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            <box-icon
                                                name="chevrons-right"
                                                color="#9ca3af"
                                            ></box-icon>
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            {{ record.ref_id }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            {{ record.name }}
                                            {{ record.surname }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            {{ moment(record.dat).format("L") }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            <p
                                                class=""
                                                :class="
                                                    record.type === 1
                                                        ? 'text-sky-500'
                                                        : record.type === 2
                                                        ? 'text-orange-400'
                                                        : 'text-green-600'
                                                "
                                            >
                                                <font v-if="record.type === 1"
                                                    >เข้างาน</font
                                                >
                                                <font v-else-if="record.type === 2"
                                                    >vvdงาน</font
                                                >
                                                <font v-else
                                                    >เพิ่มข้อมูล</font
                                                >
                                            </p>
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            <img
                                                v-if="record.pic"
                                                class="mx-auto rounded-full object-cover object-center h-10 w-10"
                                                alt=""
                                                :src="
                                                    path +
                                                    '/' +
                                                    record.y +
                                                    '/' +
                                                    record.m +
                                                    '/' +
                                                    record.d +
                                                    '/' +
                                                    record.pic
                                                "
                                            />
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            {{ record.timeold }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2 text-green-600"
                                        >
                                            {{ record.timenew }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap border-r px-6 py-2"
                                        >
                                            {{ record.other }}
                                        </td>
                                    </tr>
                                </thead>
                            </tbody>
                        </transition-group>
                    </table>
                    <div class="mt-4">
                        <TailwindPagination
                            :data="recordList"
                            @pagination-change-page="getRecord"
                        >
                        </TailwindPagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import "boxicons";
import moment from "moment";
import "moment/dist/locale/th";
import axios from "axios";
import { TailwindPagination } from "laravel-vue-pagination";

export default {
    mounted() {
        this.getRecord();
    },
    data() {
        return {
            path: "/storage/img",
            recordList: [],
            moment: moment,
        };
    },
    methods: {
        async getRecord(page = 1) {
            axios
                .get("/api/record?page=" + page)
                .then((response) => {
                    this.recordList = response.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        momentTime(data) {
            return moment(data).format("hh:mm:ss");
        },
    },
    components: {
        TailwindPagination,
    },
};
</script>

<style>
.boxplus:hover {
    color: red;
}
</style>
