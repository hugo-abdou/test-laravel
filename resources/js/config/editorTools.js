import Header from '@editorjs/header';
import Image from '@editorjs/simple-image';
export default {
    header: {
        class: Header,
        config: {
            placeholder: 'Enter a heading her...',
            levels: [2, 3, 4],
            defaultLevel: 2,
        },
        inlineToolbar: true,
    },
    image: {
        class: Image,
        inlineToolbar: true,
    },
};
