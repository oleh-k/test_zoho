
<template>
    <div class="center" style="width:600px">
        <!-- <div> -->
            <table width="600">
                <tr>
                    <th>Name</th>
                    <th>Website</th>
                    <th>Phone</th>
                    <th>Deal</th>
                </tr>
                <tr v-for="account in accounts">
                    <td>
                        <a :href="zohoLink + account.zoho_account_id" target="_blank" title="open in zoho">{{ account.name }}</a>
                    </td>
                    <td>
                        <a :href="account.website" target="_blank">{{ account.website }}</a>
                    </td>
                    <td>
                        {{ account.phone }}
                    </td>
                    <td>
                        <a :href="zohoLinkDeal + account.zoho_deal_id" target="_blank" title="open in zoho">{{ account.deal_name }}</a>
                    </td>
                </tr>
            </table>
        
            
        <!-- </div> -->
    </div>
</template>

<script>

export default {
    data() {
        return {
            accounts: [{website:'', name:''}],
            zohoLink: 'https://crm.zoho.eu/crm/org20087641148/tab/Accounts/',
            zohoLinkDeal: 'https://crm.zoho.eu/crm/org20087641148/tab/Potentials/',
        }
    },
    methods: {

        getAccounts () {

            axios.get('api/accounts/accountsAndDeals').then((res) => {
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