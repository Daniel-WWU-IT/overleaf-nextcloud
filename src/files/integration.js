import { registerFileAction, Permission, FileType } from "@nextcloud/files";
import { generateUrl } from "@nextcloud/router";
import axios from "@nextcloud/axios";

import OverleafV6Icon from "../../img/app-v6-bl.svg?raw";

const openInOverleafAction = {
	id: "overleafv6-open",
	displayName: () => {
		return "Open file in Overleaf"
	},
	enabled({ nodes, view }) {
		return nodes.length === 1
			&& !nodes.some(({ permissions }) => (permissions & Permission.READ) === 0)
			&& nodes.every(({ type }) => type === FileType.File)
			&& nodes.every(({ mime }) => mime === "application/x-tex" || mime === "application/zip")
	},
	iconSvgInline: () => OverleafV6Icon,
	async exec({ nodes }) {
		await openInOverleafV6(nodes[0]);
		return null;
	},
	async execBatch({ nodes }) {
		await openInOverleafV6(nodes[0]);
		return nodes.map(_ => null);
	},
}
registerFileAction(openInOverleafAction);

async function openInOverleafV6(node) {
	console.log("Opening file in Overleaf V6");
}
