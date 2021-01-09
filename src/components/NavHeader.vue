<template>
    <nav>
        <div class="spacer"></div>
        <div class="top-banner">

            <div class="hamburger" :class="{open: menuOpen}" @click="toggleMenu">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>

            <div class="overlay" :class="{open: menuOpen}">
                <div class="container">
                    <nav>
                        <ul>
                            <li class="ham-item">
                                <router-link @click.native="closeMenu" class="ham-link nav-link" to="/contact">Contact Us</router-link>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>


            <nav class="nav navbar">
                <router-link @click.native="closeMenu()" class="nav-link boilerplate-logo" to="/"><img src="images/boilerplate_logo.png" alt="boilerplate logo"></router-link>
                <router-link @click.native="closeMenu()" class="nav-link nav-item nav-contact" to="/contact"><img src="images/text_contact.svg" alt="contact link"></router-link>
            </nav>
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