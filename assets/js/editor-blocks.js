( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el } = wp.element;
	const { __ } = wp.i18n;
	const ServerSideRender = wp.serverSideRender;

	const blocks = [
		{
			name: 'cool-air-usa/site-header',
			title: __( 'Site Header', 'cool-air-usa' ),
			description: __( 'Primary header and navigation.', 'cool-air-usa' ),
			icon: 'editor-kitchensink',
		},
		{
			name: 'cool-air-usa/site-footer',
			title: __( 'Site Footer', 'cool-air-usa' ),
			description: __( 'Global footer and legal links.', 'cool-air-usa' ),
			icon: 'editor-kitchensink',
		},
		{
			name: 'cool-air-usa/homepage',
			title: __( 'Homepage', 'cool-air-usa' ),
			description: __( 'Homepage sections rendered in theme order.', 'cool-air-usa' ),
			icon: 'layout',
		},
		{
			name: 'cool-air-usa/service-page',
			title: __( 'Service Page', 'cool-air-usa' ),
			description: __( 'Dynamic service page content based on the current page slug.', 'cool-air-usa' ),
			icon: 'admin-tools',
		},
		{
			name: 'cool-air-usa/about-page',
			title: __( 'About Page', 'cool-air-usa' ),
			description: __( 'About page layout.', 'cool-air-usa' ),
			icon: 'id',
		},
		{
			name: 'cool-air-usa/contact-page',
			title: __( 'Contact Page', 'cool-air-usa' ),
			description: __( 'Contact page layout.', 'cool-air-usa' ),
			icon: 'email',
		},
		{
			name: 'cool-air-usa/membership-page',
			title: __( 'Membership Page', 'cool-air-usa' ),
			description: __( 'Membership plans page layout.', 'cool-air-usa' ),
			icon: 'groups',
		},
		{
			name: 'cool-air-usa/financing-page',
			title: __( 'Financing Page', 'cool-air-usa' ),
			description: __( 'Financing page layout.', 'cool-air-usa' ),
			icon: 'money-alt',
		},
		{
			name: 'cool-air-usa/careers-page',
			title: __( 'Careers Page', 'cool-air-usa' ),
			description: __( 'Careers page layout.', 'cool-air-usa' ),
			icon: 'businessperson',
		},
		{
			name: 'cool-air-usa/specials-page',
			title: __( 'Specials Page', 'cool-air-usa' ),
			description: __( 'Special offers page layout.', 'cool-air-usa' ),
			icon: 'tickets-alt',
		},
		{
			name: 'cool-air-usa/brands-page',
			title: __( 'Brands Page', 'cool-air-usa' ),
			description: __( 'Brands page layout.', 'cool-air-usa' ),
			icon: 'tag',
		},
		{
			name: 'cool-air-usa/service-areas-page',
			title: __( 'Service Areas Page', 'cool-air-usa' ),
			description: __( 'Service areas page layout.', 'cool-air-usa' ),
			icon: 'location-alt',
		},
		{
			name: 'cool-air-usa/legal-page',
			title: __( 'Legal Page', 'cool-air-usa' ),
			description: __( 'Privacy policy or terms of service page.', 'cool-air-usa' ),
			icon: 'media-document',
			attributes: {
				kind: {
					type: 'string',
					default: 'privacy',
				},
			},
		},
	];

	blocks.forEach( function ( block ) {
		registerBlockType( block.name, {
			apiVersion: 3,
			title: block.title,
			description: block.description,
			icon: block.icon,
			category: 'theme',
			attributes: block.attributes || {},
			supports: {
				html: false,
				align: [ 'wide', 'full' ],
				spacing: {
					margin: true,
					padding: true,
				},
				dimensions: {
					minHeight: true,
				},
			},
			edit: function ( props ) {
				return el( ServerSideRender, {
					block: block.name,
					attributes: props.attributes,
				} );
			},
			save: function () {
				return null;
			},
		} );
	} );
} )( window.wp );
