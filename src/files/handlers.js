import { generateUrl } from "@nextcloud/router";

import { Overleaf_AppID } from "../overleaf.js";

export async function openInOverleaf(node) {
	const appUrl = generateUrl(`/apps/${Overleaf_AppID}/integration/import-file/${node.fileid}`);
    window.location.replace(appUrl);
}

/* Makes no sense right now, but could be useful in the future.
export async function createNewTexDocument(context, content) {
    console.log("Creating new LaTeX document");
}
*/
