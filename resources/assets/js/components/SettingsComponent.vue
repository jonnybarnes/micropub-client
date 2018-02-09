<template>
    <div>
        <table class="table is-bordered">
            <tbody>
                <tr>
                    <th>me</th>
                    <td><code>{{ userData.me }}</code></td>
                </tr>
                <tr>
                    <th>token</th>
                    <td><code>{{ userData.token }}</code></td>
                </tr>
                <tr>
                    <th>Scope</th>
                    <td><code>{{ userData.scope }}</code></td>
                </tr>
                <tr>
                    <th>Method</th>
                    <td>{{ userData.method }}</td>
                <tr>
                    <th>Micropub Endpoint</th>
                    <td><code>{{ userData.micropub_endpoint }}</code></td>
                </tr>
                <tr>
                    <th>Media Endpoint</th>
                    <td><code>{{ userData.media_endpoint }}</code></td>
                <tr>
                <tr>
                    <th>Syndication Targets</th>
                    <td><pre>{{ prettyPrint(userData.syndication_targets) }}</pre></td>
                </tr>
            </tbody>
        </table>
        <p>We can query the micropub endpoint to check what, if any, the media endpoint and syndication targets are.</p>
        <p><button type="button" class="button" v-on:click="queryEndpoint">Query Endpoint</button></p>
    </div>
</template>
<script>
    module.exports = {
        props: {
            user: {
                type: Object,
                required: true,
            }
        },
        data: function () {
            return {
                userData: this.user,
            }
        },
        methods: {
            prettyPrint: function (jsonString) {
                if (jsonString == null) {
                    return null;
                }

                return JSON.stringify(JSON.parse(jsonString), null, 4);
            },
            queryEndpoint: function () {
                axios.get('/dashboard/settings/query', {
                    'withCredentials': true
                }).then((response) => {
                    this.userData.media_endpoint = response.data.media_endpoint;
                    this.userData.syndication_targets = response.data.syndication_targets;
                }).catch(error => {
                    console.error(error);
                });
            }
        }
    }
</script>
<style>
    table {
        width: 100%;
        table-layout: fixed;
    }
    th {
        width: 20%;
        min-width: 100px;
    }
    code {
        overflow-wrap: break-word;
    }
</style>