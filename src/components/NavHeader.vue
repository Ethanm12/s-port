<template>
    <nav>
        <div class="navlogo">
            <h1 class="heading">Sean William G</h1>
        </div>
        <div class="hamburger1">
            <span></span>
            <span></span>
            <span></span>
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