import LoginComponent from './components/Login.vue';
import LogoutComponent from './components/Logout.vue';
import DashboardComponent from './components/Dashboard.vue';
import BankAccountListComponent from './components/bank-account/BankAccountList.vue';
import BankAccountCreateComponent from './components/bank-account/BankAccountCreate.vue';
import BankAccountUpdateComponent from './components/bank-account/BankAccountUpdate.vue';
import PlanAccountComponent from './components/category/PlanAccount.vue';
import BillPayListComponent from './components/bill/bill-pay/BillPayList.vue';

export default {
    '/login': {
        name: 'auth.login',
        component: LoginComponent,
        auth: false
    },
    '/logout': {
        name: 'auth.logout',
        component: LogoutComponent,
        auth: true
    },
    '/dashboard': {
        name: 'dashboard',
        component: DashboardComponent,
        auth: true
    },
    '/bank-accounts': {
        component: {template: "<router-view></router-view>"},
        subRoutes: {
            '/': {
                name: 'bank-account.list',
                component: BankAccountListComponent,
                auth: true
            },
            '/create': {
                name: 'bank-account.create',
                component: BankAccountCreateComponent,
                auth: true
            },
            '/:id/update': {
                name: 'bank-account.update',
                component: BankAccountUpdateComponent,
                auth: true
            }
        }
    },
    '/plan-account': {
        name: 'plan-account',
        component: PlanAccountComponent,
        auth: true
    },
    '/bill-pay': {
        component: {template: "<router-view></router-view>"},
        subRoutes: {
            '/': {
                name: 'bill-pay.list',
                component: BillPayListComponent,
                auth: true
            }
        }
    }
}