import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { Panel, TextControl } from '@wordpress/components';
import { useSelect, useDispatch, select } from '@wordpress/data';
import { __ } from '@wordpress/i18n';


const CustomField = () => {
	const getMeta = useSelect( () => {
		return select( 'core/editor' ).getEditedPostAttribute( 'meta' );
	} );

	// console.log(getMeta);
	const duration = getMeta && getMeta._itineris_sidebar_opt_duartion_meta;
	const codeUrl = getMeta && getMeta._itineris_sidebar_opt_code_url_meta;

	const { editPost } = useDispatch( 'core/editor' );

	const onDurationUpdate = ( val ) => {
		editPost( {
			meta: {
				_itineris_sidebar_opt_duartion_meta: val,
			},
		} );
	};

	const onCodeUrlUpdate = ( val ) => {
		editPost( {
			meta: {
				_itineris_sidebar_opt_code_url_meta: val,
			},
		} );
	};

	return (
		<>
			<TextControl
				label={ __( 'Duration (minutes)', 'itineris-sidebar-opt' ) }
				value={ duration }
				onChange={ ( value ) => onDurationUpdate( value ) }
			/>
			<TextControl
				label={ __( 'Course code (url)', 'itineris-sidebar-opt' ) }
				value={ codeUrl }
				onChange={ ( value ) => onCodeUrlUpdate( value ) }
			/>
		</>
	);
};

registerPlugin( 'itineris-additional-meta', {
	render () {
		const postType = select( 'core/editor' ).getCurrentPostType();

		if ( postType !== 'itineris_course' ) {
			return null;
		}

		return (
			<PluginDocumentSettingPanel
				title={ __( 'Custom Fields', 'itineris-sidebar-opt' ) }
				initialOpen="true"
			>
				<Panel>
					<CustomField />
				</Panel>
			</PluginDocumentSettingPanel>
		);
	},
} );