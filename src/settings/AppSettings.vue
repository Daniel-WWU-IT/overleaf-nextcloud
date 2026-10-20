<script setup>
import debounce from "debounce";
import { ref, unref } from "vue";

import axios from "@nextcloud/axios";
import { loadState } from "@nextcloud/initial-state";

import { generateUrl } from "@nextcloud/router";
import NcCheckboxRadioSwitch from "@nextcloud/vue/components/NcCheckboxRadioSwitch";
import NcTextField from "@nextcloud/vue/components/NcTextField";

const appUrl = ref(loadState("overleafv6_nextcloud", "app_url"));
const apiKey = ref(loadState("overleafv6_nextcloud", "api_key"));
const userIdSuffix = ref(loadState("overleafv6_nextcloud", "userid_suffix"));
const userIdSuffixEnforce = ref(loadState("overleafv6_nextcloud", "userid_suffix_enforce"));

async function saveSettings(values) {
  await axios.put(
      generateUrl("/apps/overleafv6_nextcloud/settings"),
      values
  );
}

const onSettingsChanged = debounce(async () => {
  const values = {
      url: unref(appUrl),
      apiKey: unref(apiKey),
      suffix: unref(userIdSuffix),
      enforceSuffix: unref(userIdSuffixEnforce),
    };
    await saveSettings(values, false);
}, 500);
</script>

<template>
  <div id="overleaf-appsettings" class="section">
    <div>
      <h2>Overleaf V6 Settings</h2>
    </div>

    <div id="main-settings-section" style="padding-bottom: 1rem;">
      <div class="section-header">
        <h3>Main</h3>
      </div>
      <div style="padding-bottom: 1rem;">Configure the main Overleaf V6 settings.</div>

      <div class="settings-table">
        <NcTextField id="app-url" v-model="appUrl" class="input" label="Overleaf URL" placeholder="https://overleaf.mydomain.com" @update:model-value="onSettingsChanged" />
        <div class="settings-table-info"><em>The URL of your Overleaf V6 instance.</em></div>

        <NcTextField id="api-key" v-model="apiKey" class="input" label="API key" placeholder="secret-key-1234" @update:model-value="onSettingsChanged" />
        <div class="settings-table-info"><em>The key used to authenticate against the Overleaf V6 API.</em></div>
      </div>

      <div id="userid-settings-section">
        <div class="section-header">
          <h3>User IDs</h3>
        </div>
        <div style="padding-bottom: 1rem;">Configure how the user IDs for Overleaf V6 are generated.</div>
        <div style="padding-bottom: 1rem;">
          <em>By default, a suffix (if specified) is only appended to a Nextcloud ID if it is not an email address. This behavior can be changed by enforcing the suffix.</em>
        </div>

        <div class="settings-table">
          <NcTextField id="userid-suffix" v-model="userIdSuffix" class="input" label="Suffix" placeholder="mydomain.com" @update:model-value="onSettingsChanged" />
          <div class="settings-table-info"><em>The user IDs will be generated in the form of <i>nextcloud-id@suffix</i>. It should thus be in the form of <i>host.tld</i>, like <i>mydomain.com</i>.</em></div>

          <NcCheckboxRadioSwitch v-model="userIdSuffixEnforce" @update:model-value="onSettingsChanged">Enforce suffix</NcCheckboxRadioSwitch>
          <div class="settings-table-info"><em>If enabled, user IDs which already are an email address will nonetheless use the specified suffix.</em></div>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>

</style>
