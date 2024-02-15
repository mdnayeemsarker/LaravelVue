<template>
    <NavBar v-if="$store.getters.getToken != 0"></NavBar>
    <SideBar v-if="$store.getters.getToken != 0"></SideBar>
    <router-view></router-view>
    <Footer v-if="$store.getters.getToken != 0"> </Footer>
</template>
<script>
    import SideBar from './SideBar.vue';
    import NavBar from './NavBar.vue';
    import Footer from './Footer.vue';
    export default {
        setup() {},
        components: {
            NavBar,
            SideBar,
            Footer,
        }
    }
</script>
