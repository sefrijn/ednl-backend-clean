const { select, subscribe } = wp.data;
wp.domReady(function () {
  let wasSavingPost = select("core/editor").isSavingPost();
  let wasAutosavingPost = select("core/editor").isAutosavingPost();
  let wasPreviewingPost = select("core/editor").isPreviewingPost();
  // Save metaboxes when performing a full save on the post.
  subscribe(() => {
    const isSavingPost = select("core/editor").isSavingPost();
    const isAutosavingPost = select("core/editor").isAutosavingPost();
    const isPreviewingPost = select("core/editor").isPreviewingPost();

    // Save metaboxes on save completion, except for autosaves that are not a post preview.
    const shouldTriggerMetaboxesSave =
      (wasSavingPost && !isSavingPost && !wasAutosavingPost) ||
      (wasAutosavingPost && wasPreviewingPost && !isPreviewingPost);

    // Save current state for next inspection.
    wasSavingPost = isSavingPost;
    wasAutosavingPost = isAutosavingPost;
    wasPreviewingPost = isPreviewingPost;

    if (shouldTriggerMetaboxesSave) {
      const authorName = wp.data.select("core").getCurrentUser().name;
      console.log("Trigger Github deploy");
      if (deployment.deployment_status === "1" && deployment.github_key) {
        fetch(
          `https://api.github.com/repos/${deployment.github_user}/${deployment.repository_slug}/dispatches`,
          {
            method: "POST",
            headers: {
              Authorization: "token " + deployment.github_key,
              Accept: "application/vnd.github+json",
            },
            body: JSON.stringify({
              event_type: "Wordpress Update by " + authorName,
            }),
          }
        );
      }
      wp.data
        .dispatch("core/notices")
        .createNotice(
          "success",
          "Je wijzigingen zijn opgeslagen, " +
            authorName +
            (deployment.deployment_status === "1"
              ? ". Wacht 2-3 minutens voordat je wijzigingen zichtbaar zijn aan de voorkant."
              : ". Wijzigingen zijn pas zichtbaar aan de voorkant na een update uitgevoerd door een beheerder."),
          {
            isDismissible: true,
            id: "1",
          }
        );
    }
  });
});
