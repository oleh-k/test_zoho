
<template>
    <div class="center">
        <div>
            <input type="text" v-model="name" id="name" placeholder="name">
        </div>
        <div>
            <input type="text" v-model="stage" id="stage" placeholder="stage">
        </div>
        <div>
            <select name="account" id="account" v-model="account">
                <option v-for="account in accounts" :value="account.id">
                    {{ account.name }}
                </option>
            </select>
        </div>
        <div>
            <button @click="createDeal()" class="button">submit</button>
        </div>
        <div>
            {{result}}
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            name: '',
            stage: '',
            account: '',
            result: '',
            accounts: []

        }
    },
    methods: {

        createDeal () {

            const formData = new FormData();
            formData.append('name', this.name);
            formData.append('stage', this.stage);
            formData.append('account', this.account);

            const headers = { 
                'Content-Type': 'multipart/form-data',
                'Accept': 'application/json',
             };

            axios.post('api/deals', formData, { headers }).then((res) => {
                this.result = res.data
            }).catch((res) => {
                console.log(res)
                this.result = res.response.data
            })


        },

        getAccounts () {

            axios.get('api/accounts').then((res) => {
                console.log(res.data)
                this.accounts = res.data.data
            }).catch((res) => {
                console.log(res)
            })

        }


    },
    mounted() {
        this.getAccounts();
    }
}
</script>