import { createAppConfig } from "@nextcloud/vite-config";
import { join, resolve } from "path";

export default createAppConfig(
	{
		jquery: resolve(join("src", "lib/jquery.js")),
		launcher_app: resolve(join("src", "launcher/app.js")),
		launcher_launcher: resolve(join("src", "launcher/launcher.js")),
		settings_appsettings: resolve(join("src", "settings/appsettings.js")),
	},
	{
		inlineCSS: true,
	},
);
