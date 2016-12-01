<?php
/**
 * 计划任务.
 */
class Crond extends Base_Controller {

    public function market_bonus()
    {
        $ip = $this->input->ip_address();
        if(!in_array($ip, ['127.0.0.1', '0.0.0.0']))
        {
            echo '非法访问';
            return;
        }

        $date = $this->input->get('date');
        if(!$date)
        {
            $date = date('Y-m-d');
        }
        if($date > date('Y-m-d') || !preg_match('/\d{4}-\d{2}-\d{2}/', $date))
        {
            echo '日期非法';
            return;
        }
        
        $log = $this->db->select('*')->from('market_bonus_log')
            ->where(['log_date' => $date])
            ->get()->first_row('array');

        if($log)
        {
            echo '当天市场奖已发放';
            return;
        }

        $market_bonus = mt_rand('4700', '5000') / 10000;

        $this->db->trans_begin();

        $account_bonus_config = config_item('account_bonus_config');
        $bonus_max = $account_bonus_config['bonus_max'];
        $flage = $bonus_max - $market_bonus;

        $this->db->set('market_bonus', 'market_bonus + ' . $market_bonus, false)
            ->set('market_bonus_total', 'market_bonus_total + ' . $market_bonus, false)
            ->set('bonus_total', 'bonus_total + ' . $market_bonus, false)
            ->where('bonus_total <', $flage)
            ->where('status', 2)
            ->update('user');

        $this->db->set('market_bonus', 'market_bonus + ' . $bonus_max . ' - bonus_total', false)
            ->set('market_bonus_total', 'market_bonus_total + ' . $bonus_max . ' - bonus_total', false)
            ->set('bonus_total', 100)
            ->set('status', 3)
            ->where('bonus_total >=', $bonus_max - $market_bonus)
            ->where('status', 2)
            ->update('user');

        //倍投
        $this->db->set('market_bonus', 'market_bonus + cast_num * ' . $market_bonus, false)
            ->set('market_bonus_total', 'market_bonus_total + cast_num * ' . $market_bonus, false)
            ->where('market_bonus_total < ', 'cast_num * ' . $flage, false)
            ->where('status', 0)
            ->update('user_cast');

        $this->db->set('market_bonus', 'market_bonus + cast_num * ' . $bonus_max . ' - market_bonus_total', false)
            ->set('market_bonus_total', 'cast_num * ' . $bonus_max, false)
            ->set('status', 3)
            ->where('market_bonus_total >= ', 'cast_num * ' . $flage, false)
            ->where('status', 0)
            ->update('user_cast');


        $data = [
            'market_bonus' => $market_bonus,
            'log_date' => $date,
        ];
        $this->db->insert('market_bonus_log', $data);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            echo '发放失败';
        }
        else
        {
            $this->db->trans_commit();
            echo '发放成功';
        }

        return;
    }

}