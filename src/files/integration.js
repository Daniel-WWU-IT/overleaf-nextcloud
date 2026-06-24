import { registerFileAction, addNewFileMenuEntry, Entry, Permission, FileType } from "@nextcloud/files";
import { t } from "@nextcloud/l10n";

import { openInOverleafV6, createNewTexDocument } from "./overleaf_handlers.js";

import OverleafV6Icon from "../../img/app-v6-bl.svg?raw";

const OverleafV6_AppID = "overleafv6_nextcloud";

/*** Open LaTeX Document Action ***/

const openTexDocumentAction = {
	id: "overleafv6-open",
	displayName: () => t(OverleafV6_AppID, "Open in Overleaf V6"),
	enabled: ({ nodes, view }) => { 
		return nodes.length === 1
			&& !nodes.some(({ permissions }) => (permissions & Permission.READ) === 0)
			&& nodes.every(({ type }) => type === FileType.File)
			&& nodes.every(({ mime }) => mime === "application/x-tex")
	},
	iconSvgInline: () => OverleafV6Icon,
	exec: async ({ nodes }) => {
		await openInOverleafV6(nodes[0]);
	},
	execBatch: async ({ nodes }) => {
		await openInOverleafV6(nodes[0]);
		return nodes.map(_ => null);
	},
};

registerFileAction(openTexDocumentAction);

/*** Create New LaTeX Document Action ***/

const createNewTexDocumentAction = {
    id: "overleafv6-create",
    displayName: t(OverleafV6_AppID, "Create new LaTeX document"),
    iconSvgInline: OverleafV6Icon,
    handler: async (context, content) => {
        await createNewTexDocument(context, content);
    }
};

addNewFileMenuEntry(createNewTexDocumentAction);
