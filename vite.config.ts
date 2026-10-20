import { createAppConfig } from "@nextcloud/vite-config";
import { join, resolve } from "path";

const isProduction = process.env.NODE_ENV === "production";

export default createAppConfig(
	{
		jquery: resolve(join("src", "lib/jquery.js")),
		launcher_app: resolve(join("src", "launcher/app.js")),
		launcher_launcher: resolve(join("src", "launcher/launcher.js")),
		settings_appsettings: resolve(join("src", "settings/appSettings.js")),
	},
	{
		inlineCSS: true,
		minify: isProduction,
	},
);
