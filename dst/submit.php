<?php
/**
 * @wordpress-plugin
 * Plugin Name: Submit
 * Text Domain: submit
 */

function R($r){
    if ($r) return '*';
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
            '<form id="div-'.$node['name'].'" name="'.$node['name'].'" cost="0" method="post">'.
                '<div>'.$node['label'].'</div>'.
                    implode(array_map('render_node', $node['value'])).
                '<button type="submit" name="submit" class="button" text="'.S($node['state']).S(A($node['state'])[$_SERVER['REQUEST_METHOD']]).'">'.'</button>'.
                '<script>
                    document
                        .querySelectorAll(`form#div-'.$node['name'].'>div`)
                        .forEach(div => div.addEventListener("change", e => (
                            document
                                .querySelector(`form#div-'.$node['name'].'`)
                                .dispatchEvent(new Event("change"))
                        )))

                    document
                        .querySelector(`form#div-'.$node['name'].'`)
                        .addEventListener("change", e => (
                            document
                                .querySelector(`form#div-'.$node['name'].'`).attributes.cost.value = 0,
                            document
                                .querySelectorAll(`form#div-'.$node['name'].'>div`)
                                .forEach(div =>
                                    document.querySelector(`form#div-'.$node['name'].'`).attributes.cost.value = 
                                        (Number(document.querySelector(`form#div-'.$node['name'].'`).attributes.cost.value) || 0) + 
                                        (Number(div.attributes.cost?.value) || 0)
                                ),
                            document
                                .querySelector(`form#div-'.$node['name'].'>button`).innerHTML = [
                                    document.querySelector(`form#div-'.$node['name'].'>button[name="submit"]`).attributes.text.value,
                                    document.querySelector(`form#div-'.$node['name'].'`).attributes.cost.value
                                ].join(` `)
                        ))

                    document
                        .querySelector(`form#div-'.$node['name'].'`)
                        .dispatchEvent(new Event("change"))    
                </script>'. 
            '</form>';


    else if ($node['type'] == 'node')            
        return
            '<div id="div-'.$node['name'].'" cost="0">'.
                '<div>'.$node['label'].'</div>'.
                implode(array_map('render_node', $node['value'])).
                '<script>
                    document
                        .querySelectorAll(`div#div-'.$node['name'].'>div`)
                        .forEach(div => div.addEventListener("change", e => (
                            document
                                .querySelector(`div#div-'.$node['name'].'`)
                                .dispatchEvent(new Event("change"))
                        )))

                    document
                        .querySelector(`div#div-'.$node['name'].'`)
                        .addEventListener("change", e => (
                            document
                                .querySelector(`div#div-'.$node['name'].'`).attributes.cost.value = 0,
                            document
                                .querySelectorAll(`div#div-'.$node['name'].'>div`)
                                .forEach(div =>
                                    document.querySelector(`div#div-'.$node['name'].'`).attributes.cost.value = 
                                        (Number(document.querySelector(`div#div-'.$node['name'].'`).attributes.cost.value) || 0) + 
                                        (Number(div.attributes.cost?.value) || 0)
                                )
                        ))

                    document
                        .querySelector(`div#div-'.$node['name'].'`)
                        .dispatchEvent(new Event("change"))    
                </script>'.
            '</div>';


    else if ($node['type'] == 'text')
        return
            '<div id="div-'.$node['name'].'" cost="0">'.
                '<label for="'.$node['name'].'" >'.implode(' ', [S($node['label']), R($node['required'])]).'</label>'.'&nbsp;'.
                '<input id="'.$node['name'].'" name="'.$node['name'].'" type="text"'.' value="'.$node['value'].'" placeholder="'.$node['placeholder'].'" >'.
            '</div>';


    else if ($node['type'] == 'select')
        return
            '<div id="div-'.$node['name'].'" cost="0">'.
                '<label for="'.$node['name'].'">'.implode(' ', [S($node['label']), R($node['required'])]).'</label>'.'&nbsp;'.
                '<select id="'.$node['name'].'" name="'.$node['name'].'" state="'.$node['state'].'">'.
                    implode(array_map(
                        function($node){
                            return '<option value="'.$node['name'].'"cost="'.V($node['value']).'">'.V($node).implode(' ', array_filter([S($node['label']), V($node['value'])])).'</option>';
                        },
                        $node['value']
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
                                .forEach(div =>
                                    div.style.display = "none"
                                ),
                            document
                                .querySelector(`div#div-'.$node['name'].'>#div-${e.target.value}`)
                                .style.display  = "revert"
                        ))

                    document
                        .querySelector(`div#div-'.$node['name'].'>select`)
                        .value = document.querySelector(`div#div-'.$node['name'].'>select`).attributes.state.value || 0
                    document
                        .querySelector(`div#div-'.$node['name'].'>select`)
                        .dispatchEvent(new Event("change"))
                </script>'.              
            '</div>';


    else if ($node['type'] == 'check')
        return
            '<div id="div-'.$node['name'].'" cost="0">'.
                '<input type="checkbox"'.' id="'.$node['name'].'" name="'.$node['name'].'" state="'.$node['state'].'" cost="'.V($node['value']).'" value="'.S($node['value']['name']).'">'.'&nbsp;'.
                '<label for="'.$node['name'].'">'.' '.V($node['value']).' '.implode(' ', [R($node['required']), S($node['label'])]).'</label>'.
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
                                .style.display = e.target.checked == false && "none" || e.target.checked == true && "revert" || undefined
                        ))

                    document
                        .querySelector(`div#div-'.$node['name'].'>input`)
                        .checked = document.querySelector(`div#div-'.$node['name'].'>input`).attributes.state.value == `true` && true || false,
                    document
                        .querySelector(`div#div-'.$node['name'].'>input`)
                        .dispatchEvent(new Event("change"))
                </script>'.
            '</div>';

    else
        return 
            '<div>'.
                '(some shit)'.
            '</div>';
}


function render_check($node){
    return implode(array_map(
        function($key, $value) {
            return '<div>'.$key.' - '. $value.'</div>';
        },
        array_keys($_POST),
        array_values($_POST)
    ));
}

add_shortcode(
    'submit',
    [
        'GET' => function ($atts) {
            return render_node(include plugin_dir_path(__FILE__) . 'forms/' . $atts['form']);
        },
        'POST' => function ($atts) {
            return render_check(include plugin_dir_path(__FILE__) . 'forms/' . $atts['form']);
        }
    ][$_SERVER['REQUEST_METHOD']]
);
 
?>