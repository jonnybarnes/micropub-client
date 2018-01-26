<template>
    <form :action="action" method="post">
        <input type="hidden" name="_token" :value="csrf">
        <div v-if="showReply">
            <label for="reply">Reply To:</label>
            <input name="reply" id="reply">
        </div>
        <button type="button" v-if="showReply == false" v-on:click="showReply = !showReply">Reply</button>
        <div>
            <label for="note">Note:</label>
            <textarea name="note" id="note"></textarea>
        </div>
        <div v-if="targets">
            <fieldset>
                <legend>Syndication</legend>
                <template v-for="target in targets">
                    <label :for="target.uid">{{ target.name }}:</label>
                    <input :id="target.uid" name="mp-syndicate-to[]" type="checkbox" :value="target.uid">
                </template>
            </fieldset>
        </div>
        <div v-if="media">
            <p>Media Upload to <code>{{ media }}</code></p>
        </div>
        <button type="submit" name="submit">Submit</button>
    </form>
</template>
<script>
    module.exports = {
        props: {
            action: {
                type: String,
                required: true,
            },
            csrf: {
                type: String,
                required: true,
            },
            media: {
                type: String,
                required: false,
            },
            targets: {
                validator: function (value) {
                    return value[0].hasOwnProperty('uid')
                        && value[0].hasOwnProperty('name');
                },
                required: false,
            }
        },
        data: function () {
            return {
                showReply: false,
            }
        }
    }
</script>
