<template>
    <nav style="border:1px solid blue;">
        <div class="navlogo" style="border: 1px solid blue;">
            <h1 class="heading">Sean William G</h1>
        </div>
        <div class="hamburger1">
            <span>e</span>
            <span>dfe</span>
            <span>ges</span>
            <span>gew</span>
        </div>
    </nav>
    
</template>

<script>
export default {
    data: () => ({
        menuOpen: false
    }),
    methods: {
        toggleMenu() {
            this.menuOpen = !this.menuOpen;
        },
        closeMenu() {
            console.log('hello');
            this.menuOpen = false;
        }
    },
    watch: {
        '$route.fullPath'() {
            this.closeMenu();
        }
    }
}
</script>