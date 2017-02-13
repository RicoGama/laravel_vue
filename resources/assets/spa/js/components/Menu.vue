<template>
    <ul :id="o.id" class="dropdown-content" v-for="o in menusDropdown">
        <li v-for="item in o.items">
            <a v-link="{name: item.routeName}">{{ item.name }}</a>
        </li>
    </ul>
    <ul id="dropdown-logout" class="dropdown-content">
        <li>
            <a v-link="{name: 'auth.logout'}">Sair</a>
        </li>
    </ul>
    <div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper">
                <div class="row">
                    <div class="col s12">
                        <a href="#" class="brand-logo left">Code Financeiro</a>
                        <a href="#" data-activates="nav-mobile" class="button-collapse">
                            <i class="material-icons">menu</i>
                        </a>
                        <ul class="right hide-on-med-and-down">
                            <li v-for="o in menus">
                                <a href="!#" v-if="o.dropdownId" class="dropdown-button" :data-activates="o.dropdownId">
                                    {{ o.name }} <i class="material-icons right">arrow_drop_down</i>
                                </a>
                                <a v-else v-link="{name: o.routeName}">{{ o.name }}</a>
                            </li>
                            <li>
                                <a href="!#" class="dropdown-button" data-activates="dropdown-logout">
                                    {{ name }} <i class="material-icons right">arrow_drop_down</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <ul id="nav-mobile" class="side-nav">
                        <li v-for="o in menus">
                            <a v-link="{name: o.routeName}">{{ o.name }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</template>
<script type="text/javascript">
    import store from '../store/store';
    export default {
        data() {
            return {
                menus: [
                    {name: 'Conta Bancária', routeName: 'bank-account.list'},
                    {name: 'Plano de Contas', routeName: 'category.list'},
                ],
                menusDropdown: []
            }
        },
        computed: {
            name() {
                return store.state.auth.user.name;
            }
        },
        ready(){
            $('.button-collapse').sideNav();
            $('.dropdown-button').dropdown();
        }
    };
</script>