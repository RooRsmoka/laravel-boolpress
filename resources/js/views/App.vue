<template>
    <div>
        <Navbar></Navbar>
        <div class="container py-5">
            <!-- <div>
                <PostCard v-for='post of posts' :key='post.id' :post="post"></PostCard>
            </div> -->
            <router-view></router-view>
        </div>
        <Footer></Footer>
    </div>
</template>

<script>
import Navbar from "../components/Navbar.vue";
import Footer from "../components/Footer.vue";
// import PostCard from "../components/PostCard.vue";

export default {
    components: { Navbar, Footer },
    // data() {
    //     return {
    //         posts: [],
    //     }
    // }
};
</script>

<style scoped lang="scss">
</style>