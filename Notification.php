<?php
/**
 * @since 1.0.0
 */
namespace Vietfreshair\Notification;

class Notification
{
    /**
     * @var string
     */
    protected $type = '';
    
    /**
     * @var string
     */
    protected $message = '';
    
    /**
     * @var array
     */
    protected $classes = [];
    
    /**
     * @var boolean
     */
    protected $dismissible = true;
    
    /**
     * @var array
     */
    protected $notification;
    
    /**
     * Constructor
     * 
     * @param  string $type
     * @param  string $message
     * @return void
     * @since  1.0.0
     */
    public function __construct($type, $message)
    {
        if (!is_string($type) || !is_string($message)) {
            wp_die(__('It is string', TEXTDOMAIN));
        }
        
        if ($type == '' || $message == '') {
            wp_die(__('It isn\'t empty', TEXTDOMAIN));
        }
        
        $this->setClasses();
        $this->type = $type;
        $this->message = $message;
        
        add_action('admin_notices', [$this, 'displayMessage']);
    }
    
    /**
     * Set classes
     * 
     * @return void
     */
    public function setClasses()
    {
        $this->classes = [
            'success' => 'notice-success',
            'warning' => 'notice-warning',
            'error' => 'notice-error',
            'info' => 'notice-info'
        ];
    }
    
    /**
     * Get class
     * 
     * @return string
     */
    public function getClass()
    {
        $this->notification[] = 'notice';
        
        if (!array_key_exists($this->type, $this->classes)) {
            wp_die(__('Not found type of Notification', TEXTDOMAIN));
        }
        
        $this->notification[] = $this->classes[$this->type];
        
        if ($this->dismissible) {
            $this->notification[] = 'is-dismissible';
        }
        
        return implode(' ', $this->notification);
    }
    
    /**
     * Display message
     * 
     * @return void
     */
    public function displayMessage()
    {
        printf(
            '<div class="%1$s"><p>%2$s</p></div>',
            __($this->getClass(), TEXTDOMAIN),
            __($this->message, TEXTDOMAIN)
        );
    }
}
 