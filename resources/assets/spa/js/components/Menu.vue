<template>
    <ul :id="o.id" class="dropdown-content" v-for="o in menusDropdown">
        <li v-for="item in o.items">
            <a v-link="{ name: item.routeName }">{{ item.name }}</a>
        </li>
    </ul>
    <div class="navbar-fixed">
        <nav class="green">
            <div class="nav-wrapper container">
                <a href="#" class="brand-logo right">Code Contas</a>
                <a href="#" data-activates="nav-mobile" class="button-collapse">
                    <i class="material-icons">menu</i>
                </a>
                <ul class="left hide-on-med-and-down">
                    <li v-for="o in menus">
                        <a v-if="o.dropdownId" class="dropdown-button" href="#" :data-activates="o.dropdownId">
                            {{ o.name }} <i class="material-icons right">arrow_drop_down</i>
                        </a>
                        <a v-else v-link="{name: o.routeName}">{{ o.name }}</a>
                    </li>
                </ul>
                <ul id="nav-mobile" class="side-nav">
                    <li v-for="o in menus">
                        <a v-link="{ name: o.routeName }">{{ o.name }}</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>
<script type="text/javascript">
    import Auth from '../services/auth';
    export default {
        data() {
            return {
                menus: [
                    {name: 'Conta bancária', routeName: 'bank-account.list'},
                ],
                menusDropdown: [],
                user: Auth.user
            }
        },
        computed:{
            name() {
                return this.user.data ? this.user.data.name : '';
            }
        },
        ready(){
            $('.button-collapse').sideNav();
            $('.dropdown-button').dropdown();
        }
    };
</script>