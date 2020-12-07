import './editor.scss';
import './style.scss';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks

registerBlockType( 'cgb/block-border-box', {
	title: __( 'My Cool Border Box' ), // Block title.
	icon: 'shield', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	attributes: {
        content: { type: 'string' },
        color: { type: 'string'}
    },

	edit: ( props ) => {
		const updateContent = (e) => props.setAttributes({content: e.target.value});
		const updateColor = (value) => props.setAttributes({color: value.hex});
        return (
        	<div>
        		<h3>Your Cool Border Box</h3>
        		<input type="text" value={props.attributes.content} onChange={updateContent} />
        		<wp.components.ColorPicker color={props.attributes.color} onChangeComplete={updateColor} />
        	</div>
        );
	},

	save: ( props ) => <h3 style={{border: `5px solid ${props.attributes.color}`}}>{props.attributes.content}</h3>
} );
