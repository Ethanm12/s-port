<template>
    <div>
        <nav-header></nav-header>
        <div class="page"><router-view></router-view></div>
        <nav-footer></nav-footer>
    </div>
</template>

<script>
import NavHeader from './components/NavHeader.vue';
import NavFooter from './components/NavFooter.vue';
import { processMeta } from './utils/meta'
export default {
    components: { NavHeader, NavFooter },
    metaInfo: () => processMeta({
        siteName: 's-port'
    })
}
</script>