<template>
    <div>
        <Navbar></Navbar>
        <div>
            <ExampleComponentVue></ExampleComponentVue>
        </div>
        <Footer></Footer>
    </div>
</template>

<script>
import ExampleComponentVue from "../components/ExampleComponent.vue";
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";

export default {
    components: { ExampleComponentVue, Navbar, Footer },
};
</script>

<style></style>