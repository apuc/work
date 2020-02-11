<template>
    <v-app>
        <v-navigation-drawer
                v-model="drawer"
                fixed
                app
        >
            <v-list class="pa-1">
                <v-list-tile avatar>
                    <v-list-tile-content>
                        <v-list-tile-title v-if="firstName.length > 0" class="login-block">
                            <img class="login-image" :src="loginImg" alt="">
                            {{firstName}} {{secondName}}
                        </v-list-tile-title>
                        <v-list-tile-title v-else class="login-block">
                            <img class="login-image" :src="loginImg" alt="">
                            {{email}}
                        </v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>

            <v-list class="pt-0" dense>
                <v-divider></v-divider>
                <div class="main-page menu-hover">
                    <img :src="mainImg" alt="">
                    <a href="/">Главная</a>
                </div>
                <v-list-tile
                        v-for="link in linkMenu"
                        :key="link.title"
                        :to="link.url"
                        class="menu-hover"
                        @click="getMessage(link.title)"
                >
                    <v-list-tile-content>
                        <img :src="link.img" alt="">
                        <v-list-tile-title class="menu-text">
                            {{ link.title }}
                            <template v-if="link.title === 'Сообщения'">
                                <v-list-tile-title v-if="unreadMessages > 0"
                                                   class="menu-notification">
                                    {{ unreadMessages }}
                                </v-list-tile-title>
                            </template>
                        </v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
                <form class="logout-btn menu-hover" action="/site/logout" method="post">
                    <img :src="logOutImg" alt="">
                    <button type="submit">Выход</button>
                </form>
            </v-list>
        </v-navigation-drawer>
        <v-layout
                wrap
                main
        >
            <v-container>
                <v-layout justify-start menu>
                    <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
                </v-layout>
                <router-view></router-view>
            </v-container>
        </v-layout>
    </v-app>
</template>

<script>

    export default {
        name: 'App',
        components: {},
        data() {
            return {
                drawer: true,
                firstName: '',
                secondName: '',
                userId: '',
                email: '',
                unreadMessages: '',
                loginImg: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/login.png',
                mainImg: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/main.png',
                logOutImg: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/exit.png',
                linkMenu: [
                    {
                        title: 'Статистика',
                        url: '/personal-area/statistics',
                        img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/analysis.png'
                    },
                    {
                        title: 'Отклики',
                        url: '/personal-area/my-message',
                        img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/mail.png'
                    },
                    {
                        title: 'Добавить вакансию',
                        url: '/personal-area/add-vacancy',
                        img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/add_vacancy.png'
                    },
                    {
                        title: 'Добавить резюме',
                        url: '/personal-area/add-resume',
                        img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/add_resume.png'
                    },
                    {
                        title: 'Добавить компанию или частное лицо',
                        url: '/personal-area/add-company',
                        img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/add_company.png'
                    },
                    {
                        title: 'Все вакансии',
                        url: '/personal-area/all-vacancy',
                        img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/all_vacancy.png'
                    },
                    {
                        title: 'Все резюме',
                        url: '/personal-area/all-resume',
                        img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/all_resume.png'
                    },
                    {
                        title: 'Все компании',
                        url: '/personal-area/all-company',
                        img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/all_company.png'
                    },
                    {
                        title: 'Редактировать профиль',
                        url: '/personal-area/edit-profile',
                        img: `${process.env.VUE_APP_API_URL}` + '/vue/public/lk-image/profile.png'
                    },
                ],
            }
        },
        methods: {
            getMessage(title) {
                if(title !== 'Сообщения') {
                    this.$http.get(`${process.env.VUE_APP_API_URL}/request/employer/my-index?expand=phone,user.unreadMessages`)
                        .then(response => {
                                this.unreadMessages = response.data[0].user.unreadMessages;
                            }, response => {
                                this.$swal({
                                    toast: true,
                                    position: 'bottom-end',
                                    showConfirmButton: false,
                                    timer: 4000,
                                    type: 'error',
                                    title: response.data.message
                                })
                            }
                        )
                }
            },
            async getUser() {
                return await this.$http.get(`${process.env.VUE_APP_API_URL}/request/employer/my-index?expand=phone,user.unreadMessages`)
            },
        },
        beforeMount() {
            this.getUser()
                .then(response => {

                        this.firstName = response.data[0].first_name;
                        this.secondName = response.data[0].second_name;
                        this.userId = response.data[0].user_id;
                        this.email = response.data[0].user.email;
                        this.unreadMessages = response.data[0].user.unreadMessages;
                        this.email = this.email.match(/.+@/)[0];
                        this.email = this.email.slice(0, this.email.length-1);
                        localStorage.userId = this.userId;

                    }, response => {
                        this.$swal({
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 4000,
                            type: 'error',
                            title: response.data.message
                        })
                    }
                );
            if (window.innerWidth < 1265) {
                this.drawer = false;
            }
        },
    }
</script>
<style scoped>
    .container {
        margin: 0 auto;
    }

    .nav-menu {
        display: flex;
        align-items: center;
        list-style: none;
    }

    .nav-menu li {
        margin-right: 30px;
    }

    .nav-menu li a {
        color: #000000;
        text-decoration: none;
    }

    .v-list__tile__title a {
        color: inherit;
        text-decoration: none;
    }

    .main {
        padding-left: 300px;
    }

    .menu {
        display: none;
    }

    @media (max-width: 1265px) {
        .main {
            padding-left: 0;
        }

        .menu {
            display: flex;
        }
    }

    .logout-btn, .main-page {
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        color: inherit;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        font-size: 16px;
        font-weight: 400;
        height: 48px;
        margin: 0;
        padding: 0 16px;
        position: relative;
        text-decoration: none;
        -webkit-transition: background .3s cubic-bezier(.25, .8, .5, 1);
        transition: background .3s cubic-bezier(.25, .8, .5, 1);
        transition: none;
        font-weight: 500;
        height: 40px;
    }

    .logout-btn button, .main-page a {
        height: 24px;
        line-height: 24px;
        position: relative;
        text-align: left;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-decoration: none;
        color: rgba(0, 0, 0, .87);
        -webkit-transition: .3s cubic-bezier(.25, .8, .5, 1);
        transition: .3s cubic-bezier(.25, .8, .5, 1);
        width: 100%;
        font-size: 13px;
        outline: none;
    }

    .logout-btn:hover, .main-page:hover {
        background: rgba(0, 0, 0, .04);
    }

    .logout-btn img, .main-page img {
        width: 20px;
        margin-right: 10px;
    }

    .v-list__tile__content {
        align-items: center;
        flex-direction: row;
    }

    .v-list__tile__content img {
        width: 20px;
        margin-right: 10px;
    }

    .login-block {
        display: flex;
        align-items: center;
    }

    .login-image {
        width: 25px !important;
    }
    .menu-text {
        display: flex;
        align-items: center;
        height: 100%;
    }
    .menu-hover:hover {
        background-color: #deddd9;
    }
    .menu-notification {
        position: absolute;
        top: 5px;
        left: 75px;
        width: 15px;
        height: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        background: #ff0000;
        color: #ffffff !important;
        border-radius: 50%;
    }
</style>