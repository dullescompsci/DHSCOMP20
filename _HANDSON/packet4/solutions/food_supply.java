import java.util.*;
import java.awt.*;
import java.io.*;
import java.text.DecimalFormat;

public class food_supply
{
    public static void main(String[] args) throws Exception
    {
        Scanner fromFile = new Scanner(new File("food_supply.dat"));


        while(fromFile.hasNextLine())
        {
            String[] data = fromFile.nextLine().split(",");
            int minCalories = Integer.parseInt(data[0]);

            ArrayList<Integer> foodContainers = new ArrayList<>();

            for(int x=1; x<data.length; x++)
            {
                foodContainers.add(Integer.parseInt(data[x]));
            }
            System.out.println(maxDays(foodContainers, 0,0,minCalories));
        }
    }

    public static int maxDays(ArrayList<Integer> foodContainers, int caloriesFound,int daysFed, int minCalories)
    {
        //System.out.println(foodContainers.size());
        int caloriesLeft=0;

        for(Integer i: foodContainers)
            caloriesLeft+=i;

        if(foodContainers.size()==0 || caloriesFound+caloriesLeft<minCalories)
            return daysFed;

        int maxDays = -1;
        for(int x=0; x<foodContainers.size(); x++)
        {
            ArrayList<Integer> foodLeft = (ArrayList<Integer>)foodContainers.clone();
            foodLeft.remove(x);
            int days = 0;
            if(caloriesFound+foodContainers.get(x)>=minCalories)
                days=maxDays(foodLeft,0,daysFed+1,minCalories);
            else
                days=maxDays(foodLeft,caloriesFound+foodContainers.get(x),daysFed,minCalories);
            if(maxDays ==-1 || days > maxDays)
                maxDays = days;
        }

        return maxDays;
    }
}