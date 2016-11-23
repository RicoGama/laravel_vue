<template>
    <div class="container">
        <div class="row">
            <div class="col s4 z-depth-4 card-panel offset-s4">
                <span class="card-title center">
                    <h3 class="thin">Code Financeiro</h3>
                </span>
                <div class="row" v-if="error.error">
                    <div class="col s12">
                        <div class="card-panel red">
                            <span class="white-text">{{ error.message }}</span>
                        </div>
                    </div>
                </div>
                <form method="POST" @submit.prevent="login()">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="email" type="email" class="validate" name="email" v-model="user.email" required autofocus>
                            <label for="email" class="active valign-wrapper"><i class="material-icons valign">account_circle</i>Email de login</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="password" type="password" class="validate" v-model="user.password" name="password" required>
                            <label for="password" class="valign-wrapper"><i class="material-icons valign">lock_outline</i>Senha</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <button type="submit" class="btn blue btn-flat white-text waves-effect">Entrar</button>
                            <a href="#">Esqueceu a Senha?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Auth from '../services/auth';
    export default {
        data() {
            return {
                user: {
                    email: '',
                    password: '',
                },
                error: {
                    error: false,
                    message: ''
                }
            };
        },
        methods: {
            login() {
                Auth.login(this.user.email, this.user.password)
                        .then(() => this.$router.go({name: "dashboard"}))
                        .catch((responseError) => {
                            switch (responseError.status) {
                                case 401:
                                    this.error.message = responseError.data.message;
                                    break;
                                default:
                                    this.error.message = "Login inválido!"
                            }
                            this.error.error = true;
                        });
            }
        },
    }
</script>