<template>
    <!-- Replace with your content -->
    <router-view v-slot="{ Component, route }">
        <transition name="fade" mode="out-in">
            <div :key="route.name">
                <component :is="Component"></component>
            </div>
        </transition>
    </router-view>
    <!-- /End replace -->
</template>

<script>
import moment from "moment"; //format date thai
moment.locale("th");

export default {
    mounted() {},
};
</script>
