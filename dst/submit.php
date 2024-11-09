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
            '<form id="'.$node['name'].'" name="'.$node['name'].'">'.
                '<div>'.$node['label'].'</div>'.
                    implode(array_map('render_node', $node['value'])).
                '<button type="submit" name="submit" class="button">'. 
                    $node['state'].
                '</button>'.
                '<script>
                    document
                        .querySelectorAll(`form#'.$node['name'].' div>select`)
                        .forEach(select => (
                            select.addEventListener("change", event => (
                                event.target.attributes.state.value = event.target.value,
                                event.target.parentElement.setAttribute("cost",
                                    document.querySelector(`option[value="${event.target.attributes.state.value}"]`)?.attributes?.cost?.value ||
                                    document.querySelector(`div#${event.target.attributes.state.value}`)?.attributes?.cost?.value ||
                                    0   
                                )
                            ))
                        ))

                    document
                        .querySelectorAll(`form#'.$node['name'].' div>select`)
                        .forEach(select => (
                            select.value = select.attributes.state.value,
                            select.dispatchEvent(new Event("change"))
                        ))


                    document
                        .querySelectorAll(`form#'.$node['name'].' div>input[type="checkbox"]`)
                        .forEach(checkbox => (
                            checkbox.addEventListener("change", event => ( 
                                event.target.attributes.state.value = event.target.checked,
                                event.target.parentElement.setAttribute("cost",
                                    event.target.attributes.state.value == "true" && event.target.attributes.cost.value ||
                                    event.target.attributes.state.value == "true" && document.querySelector(`div#${event.target.attributes.value.value}`)?.attributes?.cost?.value ||
                                    0
                                )                          
                            ))
                        ))

                    document
                        .querySelectorAll(`form#'.$node['name'].' div>input[type="checkbox"]`)
                        .forEach(checkbox => (
                            checkbox.checked = checkbox.getAttribute(`state`) == `false` && true || `true` && false,
                            checkbox.click()
                        ))

                    
                </script>'. 
            '</form>';


    else if ($node['type'] == 'node')            
        return
            '<div id="'.$node['name'].'" name="'.$node['name'].'">'.
                '<div>'.$node['label'].'</div>'.
                implode(array_map('render_node', $node['value'])).
            '</div>';


    else if ($node['type'] == 'text')
        return
            '<div id="'.$node['name'].'" cost="0">'.
                '<label for="'.$node['name'].'" >'.implode(' ', [S($node['label']), R($node['required'])]).'</label>'.'&nbsp;'.
                '<input type="text"'.' name="'.$node['name'].'" value="'.$node['value'].'" placeholder="'.$node['placeholder'].'" >'.
            '</div>';


    else if ($node['type'] == 'select')
        return
            '<div id="'.$node['name'].'">'.
                '<label for="'.$node['name'].'">'.implode(' ', [S($node['label']), R($node['required'])]).'</label>'.'&nbsp;'.
                '<select name="'.$node['name'].'" state="'.$node['state'].'">'.
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
                        .querySelector(`[name="'.$node['name'].'"]`)
                        .addEventListener("change", e => (
                            document
                                .querySelectorAll(`#'.$node['name'].'>div`)
                                .forEach(div =>
                                    div.style.display = "none"
                                ),
                            document
                                .querySelector(`#'.$node['name'].'>#${e.target.value}`)
                                .style.display  = "revert"
                        ))
                    document
                        .querySelectorAll(`#'.$node['name'].'>div`)
                            .forEach(div =>
                                div
                                    .addEventListener("change", e => (
                                        document
                                            .querySelector(`[name="'.$node['name'].'"]`)
                                                .dispatchEvent(new Event("change"))
                                    ))
                            )
                </script>'.              
            '</div>';


    else if ($node['type'] == 'check')
        return
            '<div id="'.$node['name'].'">'.
                '<input type="checkbox"'.' name="'.$node['name'].'" state="'.$node['state'].'" cost="'.V($node['value']).'" value="'.S($node['value']['name']).'">'.'&nbsp;'.
                '<label for="'.$node['name'].'">'.' '.V($node['value']).' '.implode(' ', [R($node['required']), S($node['label'])]).'</label>'.
                render_node(A($node['value'])).
                '<script>
                    document
                        .querySelector(`[name="'.$node['name'].'"]`)
                        .addEventListener("change", e => (
                            document
                                .querySelector(`#'.A($node['value'])['name'].'`)
                                .style.display = e.target.checked == false && "none" || e.target.checked == true && "revert" || undefined
                        ))
                                        document
                        .querySelectorAll(`#'.$node['name'].'>div`)
                            .forEach(div =>
                                div
                                    .addEventListener("change", e => (
                                        document
                                            .querySelector(`[name="'.$node['name'].'"]`)
                                                .dispatchEvent(new Event("change"))
                                    ))
                            )
                </script>'.
            '</div>';

    else
        return 
            '<div>'.
                '(some shit)'.
            '</div>';
}

add_shortcode(
    'submit',
    function ($atts) {
        $atts = shortcode_atts(array('form' => ''), $atts);
        $node = include plugin_dir_path(__FILE__) . 'forms/' . $atts['form'];

        return render_node($node);
    }
);
 
?>