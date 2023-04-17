
<template>
    <div class="center">
        <div>
            <input type="text" v-model="name" id="name" placeholder="name">
        </div>
        <div>
            <input type="text" v-model="website" id="website" placeholder="website">
        </div>
        <div>
            <input type="text" v-model="phone" id="phone" placeholder="phone">
        </div>
        <div>
            <button @click="createAccount()" class="button">submit</button>
        </div>
        <div>
            {{ result }}
        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            name: '',
            website: '',
            phone: '',
            result: '',
        }
    },
    methods: {

        createAccount () {

            const formData = new FormData();
            formData.append('name', this.name);
            formData.append('website', this.website);
            formData.append('phone', this.phone);

            const headers = { 
                'Content-Type': 'multipart/form-data',
                'Accept': 'application/json',
             };

            axios.post('api/accounts', formData, { headers }).then((res) => {
                this.result = res.data
            }).catch((res) => {
                console.log(res)
                this.result = res.response.data
            })

        }


    },
    mounted() {

    }
}
</script>