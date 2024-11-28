<?php
/**
 * @wordpress-plugin
 * Plugin Name: Submit
 * Text Domain: submit
 */

function R($r){
    if ($r) return 'required';
    else return '';
}

function V($v){
    if (gettype($v) == 'integer') return $v;
    else return '';
}

function S($s){
    if (gettype($s) == 'string') return $s;
    else return '';
}

function A($a){
    if (gettype($a) == 'array') return $a;
    else return null;
}

function render_node($node){
    if ($node == null)
        return '';


    else if ($node['type'] == 'form')
        return
            '<div id="div-'.$node['name'].'" cost="0">'.
            '<form name="'.$node['name'].'" method="post">'.
                '<style>
                    div:has(>input[type=text])>label:after {content: " ";}                
                    div:has(>input[type=text][required])>label:after {content: " * ";}

                    div:has(>input[type=checkbox])>label:before {content: " ";}                        
                    div:has(>input[type=checkbox][required])>label:before {content: " * ";}
                    
                    div:has(>select)>label:after {content: " ";}                
                    div:has(>select[required])>label:after {content: " * ";}
                </style>'.
                '<div>'.$node['label'].'</div>'.
                implode(array_map('render_node', $node['value'])).                
                '<button type="submit" name="submit" class="button" text="'.S($node['state']).S(A($node['state'])[$_SERVER['REQUEST_METHOD']]).'">'.'</button>'.
                '<script>
                    document
                        .querySelectorAll(`div#div-'.$node['name'].'>form>div`)
                        .forEach(div => div.addEventListener("change", e => (
                            document
                                .querySelector(`div#div-'.$node['name'].'>form`)
                                .dispatchEvent(new Event("change"))
                        )))

                    document
                        .querySelector(`div#div-'.$node['name'].'>form`)
                        .addEventListener("change", e => (
                            document
                                .querySelector(`div#div-'.$node['name'].'`).attributes.cost.value = 0,
                            document
                                .querySelectorAll(`div#div-'.$node['name'].'>form>div`)
                                .forEach(div =>
                                    document.querySelector(`div#div-'.$node['name'].'`).attributes.cost.value = 
                                        (Number(document.querySelector(`div#div-'.$node['name'].'`).attributes.cost.value) || 0) + 
                                        (Number(div.attributes.cost?.value) || 0)
                                ),
                            document
                                .querySelector(`div#div-'.$node['name'].'>form>button`).innerHTML = [
                                    document.querySelector(`div#div-'.$node['name'].'>form>button[name="submit"]`).attributes.text.value,
                                    document.querySelector(`div#div-'.$node['name'].'`).attributes.cost.value
                                ].join(` `)
                        ))

                    document
                        .querySelector(`div#div-'.$node['name'].'>form`)
                        .dispatchEvent(new Event("change"))    
                </script>'. 
            '</form>'.
            '</div>';


    else if ($node['type'] == 'node')            
        return
            '<div id="div-'.$node['name'].'" cost="0">'.
            '<fieldset>'.
                '<div>'.$node['label'].'</div>'.
                implode(array_map('render_node', $node['value'])).
                '<script>
                    document
                        .querySelectorAll(`div#div-'.$node['name'].'>fieldset>div`)
                        .forEach(div => div.addEventListener("change", e => (
                            document
                                .querySelector(`div#div-'.$node['name'].'>fieldset`)
                                .dispatchEvent(new Event("change"))
                        )))

                    document
                        .querySelector(`div#div-'.$node['name'].'>fieldset`)
                        .addEventListener("change", e => (
                            document
                                .querySelector(`div#div-'.$node['name'].'`).attributes.cost.value = 0,
                            document
                                .querySelectorAll(`div#div-'.$node['name'].'>fieldset>div`)
                                .forEach(div =>
                                    document.querySelector(`div#div-'.$node['name'].'`).attributes.cost.value = 
                                        (Number(document.querySelector(`div#div-'.$node['name'].'`).attributes.cost.value) || 0) + 
                                        (Number(div.attributes.cost?.value) || 0)
                                )
                        ))

                    document
                        .querySelector(`div#div-'.$node['name'].'>fieldset`)
                        .dispatchEvent(new Event("change"))
                </script>'.
            '</fieldset>'.    
            '</div>';


    else if ($node['type'] == 'text')
        return
            '<div id="div-'.$node['name'].'" cost="0">'.
                '<label for="'.$node['name'].'" >'.S($node['label']).'</label>'.
                '<input type="text" '.
                    'id="'.$node['name'].'" '.
                    'name="'.$node['name'].'" '.
                        R($node['required']).' '.
                        'value="'.
                        [
                            'GET'=> $node['value'],
                            'POST' => $_POST[$node['name']]
                        ]
                        [$_SERVER['REQUEST_METHOD']].
                    '" '.
                    '" placeholder="'.$node['placeholder'].'" '.
                '>'.
            '</div>';


    else if ($node['type'] == 'check')
        return
            '<div id="div-'.$node['name'].'" cost="0">'.
                '<input type="checkbox" '.
                    'id="'.$node['name'].'" '.
                    'name="'.$node['name'].'" '.
                    R($node['required']).' '.
                    'value="'.S($node['value']['name']).'" '.
                    'state="'.
                        [
                            'GET'=> $node['state'],
                            'POST' => var_export(array_key_exists($node['name'], $_POST),true)
                        ]
                        [$_SERVER['REQUEST_METHOD']].'" '.
                    'cost="'.V($node['value']).'" '.
                '">'.
                '<label for="'.$node['name'].'">'.' '.V($node['value']).' '.S($node['label']).'</label>'.
                render_node(A($node['value'])).
                '<script>
                    document
                        .querySelectorAll(`div#div-'.$node['name'].'>div`)
                        .forEach(div => div .addEventListener("change", e => (
                            document
                                .querySelector(`div#div-'.$node['name'].'>input`)
                                .dispatchEvent(new Event("change"))
                        )))

                    document
                        .querySelector(`div#div-'.$node['name'].'>input`)
                        .addEventListener("change", e => (
                            e.target.attributes.state.value = e.target.checked,
                            e.target.parentElement.attributes.cost.value =
                                e.target.attributes.state.value == "true" &&
                                    e.target.attributes.cost.value ||
                                e.target.attributes.state.value == "true" &&
                                    document.querySelector(`div#div-${e.target.attributes.value.value}`)?.attributes?.cost?.value ||
                                    0,
                            document
                                .querySelector(`div#div-'.A($node['value'])['name'].'`)
                                .style.display = e.target.checked == false && "none" || e.target.checked == true && "revert" || undefined,
                            e.target.checked == false && document
                                .querySelectorAll(`div#div-'.A($node['value'])['name'].'>*`)
                                .forEach(div => div.setAttribute("disabled", "")) ||
                            e.target.checked == true && document
                                .querySelectorAll(`div#div-'.A($node['value'])['name'].'>*`)
                                .forEach(div => div.removeAttribute("disabled"))
                        ))

                    document
                        .querySelector(`div#div-'.$node['name'].'>input`)
                        .checked = document.querySelector(`div#div-'.$node['name'].'>input`).attributes.state.value == `true` && true || false,
                    document
                        .querySelector(`div#div-'.$node['name'].'>input`)
                        .dispatchEvent(new Event("change"))
                </script>'.
            '</div>';

        else if ($node['type'] == 'select')
            return
                '<div id="div-'.$node['name'].'" cost="0">'.
                    '<label for="'.$node['name'].'">'.S($node['label']).'</label>'.
                    '<select'.
                        ' id="'.$node['name'].
                        '" name="'.$node['name'].
                        '" state="'.
                        [
                            'GET'=> $node['state'],
                            'POST' => $_POST[$node['name']]
                        ]
                        [$_SERVER['REQUEST_METHOD']].
                    '">'.
                        implode(array_map(
                            function($name, $node){
                                return '<option value="'.$name.'"cost="'.V($node['value']).'">'.V($node).implode(' ', array_filter([S($node['label']), V($node['value'])])).'</option>';
                            },
                            array_keys($node['value']),
                            array_values($node['value'])
                        )).
                    '</select>'.
                    implode(array_map(
                        function($node){
                            return render_node(A($node['value']));
                        },
                        $node['value']
                    )).
                    '<script>
                        document
                            .querySelectorAll(`div#div-'.$node['name'].'>div`)
                            .forEach(div => div.addEventListener("change", e => (
                                document
                                    .querySelector(`div#div-'.$node['name'].'>select`)
                                    .dispatchEvent(new Event("change"))
                            )))
    
                        document
                            .querySelector(`div#div-'.$node['name'].'>select`)
                            .addEventListener("change", e => (
                                e.target.attributes.state.value = e.target.value,
                                e.target.parentElement.attributes.cost.value =
                                    document.querySelector(`option[value="${e.target.attributes.state.value}"]`)?.attributes?.cost?.value ||
                                    document.querySelector(`div#div-${e.target.attributes.state.value}`)?.attributes?.cost?.value ||
                                    0,
                                document
                                    .querySelectorAll(`div#div-'.$node['name'].'>div`)
                                    .forEach(div => div.style.display = "none"),
                                document
                                    .querySelectorAll(`div#div-'.$node['name'].'>div>*`)
                                    .forEach(div => div.setAttribute("disabled", "")),
                                document
                                    .querySelector(`div#div-'.$node['name'].'>#div-${e.target.value}`)
                                    .style.display  = "revert",
                                document
                                    .querySelectorAll(`div#div-'.$node['name'].'>#div-${e.target.value}>*`)
                                    .forEach(div => div.removeAttribute("disabled"))
                            ))
    
                        document
                            .querySelector(`div#div-'.$node['name'].'>select`)
                            .value = document.querySelector(`div#div-'.$node['name'].'>select`).attributes.state.value || 0
                        document
                            .querySelector(`div#div-'.$node['name'].'>select`)
                            .dispatchEvent(new Event("change"))
                    </script>'.              
                '</div>';

            else
        return 
            '<div>'.
                '(some shit)'.
            '</div>';
}


function render_form($node){
    if ($node == null)
        return '';


    else if ($node['type'] == 'form')
        return
            '<div id="fin-'.$node['name'].'">'.
                '<style>
                    div#fin-'.$node['name'].' span:not(:empty):after, div#fin-'.$node['name'].' span:not(:empty):before { content:" "; }
                    div#fin-'.$node['name'].' span.label, div#fin-'.$node['name'].' span.total { font-weight: bold; }
                </style>'.
                implode(array_map('render_form', $node['value'])).
                '<div>'.
                    '<span class="label">'.'Итого'.'</span>'.
                    '<span class="total">'.'0'.'</span>'.
                '</div>'.
                '<script>
                    document
                        .querySelectorAll(`div#fin-'.$node['name'].'>div>span.cost`)
                        .forEach(span =>
                            document.querySelector(`div#fin-'.$node['name'].'>div>span.total`).innerHTML = 
                                Number(document.querySelector(`div#fin-'.$node['name'].'>div>span.total`).innerHTML) +
                                Number(span.innerHTML)
                        )
                </script>'.
            '</div>';


    else if ($node['type'] == 'node')            
        return
            implode(array_map('render_form', $node['value']));


    else if ($node['type'] == 'text' && array_key_exists($node['name'], $_POST))
        return
            '<div>'.
                '<span>'.$node['label'].'</span>'.
                '<span>'.$_POST[$node['name']].'</span>'.
            '</div>';


    else if ($node['type'] == 'check' && array_key_exists($node['name'], $_POST))
        return
            '<div>'.
                '<span>'.$node['label'].'</span>'.
                '<span class="cost">'.V($node['value']).'</span>'.
            '</div>'.
            render_form(A($node['value']));


    else if ($node['type'] == 'select' && array_key_exists($node['name'], $_POST))
        return
            '<div>'.$node['label'].
                '<span>'.$node['value'][$_POST[$node['name']]]['label'].'</span>'.
                '<span class="cost">'.V($node['value'][$_POST[$node['name']]]['value']).'</span>'.
            '</div>'.
            render_form(A($node['value'][$_POST[$node['name']]]['value']));
}

add_shortcode(
    'submit',
    [
        'GET' => function ($atts) {
            return render_node(include plugin_dir_path(__FILE__) . 'forms/' . $atts['form']);
        },
        'POST' => function ($atts) {
            return render_form(include plugin_dir_path(__FILE__) . 'forms/' . $atts['form']).
            (include plugin_dir_path(__FILE__) . 'gates/' . 'tinkoff.php')('SOME SHIT');
        }
    ][$_SERVER['REQUEST_METHOD']]
);
 
?>