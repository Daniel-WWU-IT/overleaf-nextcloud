import { registerFileAction, addNewFileMenuEntry, Entry, Permission, FileType } from "@nextcloud/files";
import { t } from "@nextcloud/l10n";

import { openInOverleaf, createNewTexDocument } from "./handlers.js";
import { Overleaf_AppID } from "../overleaf.js";

import OverleafIcon from "../../img/app-v6-bl.svg?raw";

/*** Open LaTeX Document Action ***/

const openTexDocumentAction = {
	id: "overleafv6-open",
	displayName: () => t(Overleaf_AppID, "Open in Overleaf V6"),
	enabled: ({ nodes, view }) => { 
		return nodes.length === 1
			&& !nodes.some(({ permissions }) => (permissions & Permission.READ) === 0)
			&& nodes.every(({ type }) => type === FileType.File)
			&& nodes.every(({ mime }) => mime === "application/x-tex")
	},
	iconSvgInline: () => OverleafIcon,
	exec: async ({ nodes }) => {
		await openInOverleaf(nodes[0]);
	},
	execBatch: async ({ nodes }) => {
		await openInOverleaf(nodes[0]);
		return nodes.map(_ => null);
	},
};

registerFileAction(openTexDocumentAction);

/*** Create New LaTeX Document Action ***/

/* Makes no sense right now, but could be useful in the future.
const createNewTexDocumentAction = {
    id: "overleafv6-create",
    displayName: t(Overleaf_AppID, "Create new LaTeX document"),
    iconSvgInline: OverleafIcon,
    handler: async (context, content) => {
        await createNewTexDocument(context, content);
    }
};

addNewFileMenuEntry(createNewTexDocumentAction);
*/
