/**
 * Function to modify CSS on specific html elements
 * @param element
 * @param node
 */
function modifyCSS(element, node) {
	if (typeof node === 'undefined') {
		node = $('html');
	}
	for (const [nodeArrayKey, cssArrayValue] of Object.entries(listManagerVariables.nodeArrayCSS[element])) {
		for (const [prop, value] of Object.entries(cssArrayValue)) {
			node.find(nodeArrayKey).css(prop, value);
		}
	}
}

/**
 * Function to fade the BG html element.
 * @param direction
 */
function bgFade(direction) {
	let listManagerCardElement = $('#list-manager-card');
	switch (direction) {
		case "out":
			listManagerCardElement.fadeOut(listManagerVariables.fadeLength, function() {
				$(this).hide();
			});

			// Modify CSS
			modifyCSS('bgFadeElementOut');

			$("#elementreplace").html(listManagerVariables.loadingText);
			break;

		case "in":
			listManagerCardElement.fadeIn(listManagerVariables.fadeLength, function() {
				$(this).show();
			});

			// Modify CSS
			modifyCSS('bgFadeElementIn');
			break;
	}
}

$(document).ready(function() {
	/**
	 * Detect if user clicks on the html BG.
	 */
	$('#list-manager-card-bg').on("click", function() {
		bgFade("out");
	});

	/**
	 * Detect if user has clicked a card and display it.
	 */
	$('#board-container').on("click", ".viewpostcontent", function() {
		$("#elementreplace").load('./viewtopic.php', $(this).data("id"), function() {

			// Remove elements from generated page
			$(this).find(listManagerVariables.elementRemove.viewTopic).remove();

			// Remove post profile?
			if(listManagerVariables.showPostProfile === '0') {
				$(this).find(listManagerVariables.elementRemove.postProfile).remove();
				modifyCSS('postProfileElement', $(this));
			}

			// Modify CSS
			modifyCSS('viewPostElement', $(this));
		});
		bgFade("in");
	});

	/**
	 * Detect if user has clicked to create a new card and display the window.
	 */
	$('#board-container').on("click", ".newpostcontent", function() {
		$("#elementreplace").load('./posting.php?mode=post&' + $(this).data("id"), function() {

			// Remove elements from generated page
			$(this).find(listManagerVariables.elementRemove.createPost).remove();

			// Modify CSS
			modifyCSS('newPostElement', $(this));
		});
		bgFade("in");
	});

	/**
	 * Detect if user has clicked a submit button or post reply button and process it.
	 */
	$('#elementreplace').on("click", function(event){
		let submitElement = event, postReplyElement = event, postButtonsElement = event, self, reload = false;
		listManagerVariables.nodeLocation.postReply.forEach(function(value) {
			postReplyElement = postReplyElement[value];
		});
		listManagerVariables.nodeLocation.submitButton.forEach(function(value) {
			submitElement = submitElement[value];
		});
		listManagerVariables.nodeLocation.postButtons.forEach(function(value) {
			postButtonsElement = postButtonsElement[value];
		});

		self = jQuery(submitElement);

		// Check if form needs to be submitted.
		if (self.is("#postform input[type=submit]") && listManagerVariables.submitArray.indexOf(self.attr('name')) >= 0) {
			reload = true;
		} else if (postReplyElement.nodeName === 'A' && listManagerVariables.postReplyText.indexOf(postReplyElement.getAttribute('title')) >= 0) {
			reload = true;
		} else if (postButtonsElement.nodeName === 'A' && listManagerVariables.postButtonsText.indexOf(postButtonsElement.getAttribute('title')) >= 0) {
			reload = true;
		}

		//If form was submitted or is posting reply.
		if(reload === true){
			event.preventDefault();

			let form, formData, pageURL;

			if(self.is("#postform input[type=submit]") && listManagerVariables.submitArray.indexOf(self.attr('name'))) {
				form = self.closest('form');
				formData = form.serialize();
				pageURL = form.attr("action");

				if(self.attr('name')) {
					formData += (formData!=='')? '&':'';
					formData += self.attr('name') + '=' + ((self.is('button'))? self.html(): self.val());
				}
			} else {
				pageURL = postReplyElement.getAttribute('href');
			}

			jQuery.ajax({
				method: "POST",
				url: pageURL,
				dataType: "html",
				data: formData,
				success: function(data) {
					let $htmlData = $('<div />',{html:data});

					$htmlData.find(listManagerVariables.elementRemove.formSubmit).remove();
					modifyCSS('formSubmitElement', $htmlData);

					if(self.attr('name') === 'load') {
						$htmlData.find(listManagerVariables.elementRemove.loadDraft).remove();
					}

					$("#elementreplace").html($htmlData);
				}
			});

			//If loading draft
		} else if(self.is("a") && self.attr('title') === 'Load draft') {
			event.preventDefault();

			$("#elementreplace").load(self.attr("href"), function() {
				modifyCSS('formSubmitElement', $(this));
				$(this).find(listManagerVariables.elementRemove.loadDraft).remove();
			});
		}
	});
});
