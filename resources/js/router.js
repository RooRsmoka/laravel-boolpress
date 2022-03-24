import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from "./pages/Home.vue";
import Contacts from "./pages/Contacts.vue";
import PostShow from "./pages/posts/Show.vue";
import Error from "./pages/Error.vue";


Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: "/",
            component: Home,
            name: "home.index",
            meta: { title: "Homepage", linkName: "Home" },
        },
        {
            path: "/contatti",
            component: Contacts,
            name: "contacts.index",
            meta: { title: "Contatti", linkName: "Contattaci" },
        },
        {
            path: "/posts/:post",
            component: PostShow,
            name: "posts.show",
            meta: { title: "Dettagli post" },
        },
        {
            path: "/not-found",
            alias: "*",
            component: Error,
            name: "error"
        }
    ]
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title;

    next();
});

export default router;